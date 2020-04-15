import os
import re
import csv
import json

DEBUG=1
Out = {}
Champs = {}
countByCountry = {}
countByMajorStyle = {}
countByMinorStyle = {}
countByMajorStyle['b'] = {}
countByMajorStyle['d'] = {}
countByMajorStyle['e'] = {}
countByMajorStyle['h'] = {}
countByMajorStyle['o'] = {}
countByMajorStyle['s'] = {}
countByMajorStyle['v'] = {}
countByMajorStyle['x'] = {}
countByMajorStyle['z'] = {}
monitored_Nations = {}
teamByCountry = {}
teamCountByCountry = {}
countryByName = {}
countryByTri = {}
tempBadgeList = {}
nationalBadges = {}
teamBadgesByCountry = {}
teamBadgesCountByCountry = {}

tempTeamNames = []
errorList = []

totalCountries = 0
totalTeams = 0

orig_badges = []
orig_comps = []
orig_nations = []
orig_oldfile = []
orig_styles = []
orig_teams = []
the_badges = "./css/badge.css"
the_comps = "./config/comps.csv"
the_nations = "./config/nations.csv"
the_oldfile = "./config/base.json"
the_styles = "./css/style.css"
the_teams = "./config/teams.csv"

def debug(message):
	global DEBUG
	global errorList

	message.replace("~", "\n")
	if "Error" in message:
		errorList.append(message)

	if DEBUG:
		message.replace(r'\n', r'')
		print(message)

def testFilePresence(fn):
	if os.path.isfile(fn):
		debug("Can open "+fn)
		return 1
	else:
		debug("File Error: Can't open "+fn)
		exit(1)

if testFilePresence(the_oldfile):
	with open(the_oldfile) as f:
		orig_oldfile = json.load(f)
		Champs = orig_oldfile["champs"]
		f.close()

if testFilePresence(the_comps):
	with open(the_comps) as f:
		orig_comps = f.read().splitlines()
		f.close()

if testFilePresence(the_styles):
	with open(the_styles) as f:
		orig_styles = f.read().splitlines()
		f.close()

if testFilePresence(the_badges):
	with open(the_badges) as f:
		orig_badges = f.read().splitlines()
		f.close()

if testFilePresence(the_nations):
	with open(the_nations) as f:
		orig_nations = f.read().splitlines()
		f.close()

if testFilePresence(the_teams):
	with open(the_teams) as f:
		orig_teams = f.read().splitlines()
		f.close()

for c in orig_comps:
	if re.match(r"^N,", c):
		this_nat = c.split(",")
		monitored_Nations[this_nat[1]] = this_nat[3]

for c in orig_styles:
	if len(c) and c[0] == ".":
		cStyle = re.search(r"\.(.+?)\s{", c)
		cStyle = cStyle[1]
		if len(cStyle) == 2:
			countByMinorStyle[cStyle] = 0
		elif re.search(r"^.\-", cStyle):
			countByMajorStyle[cStyle[0]][cStyle] = 0

for b in orig_badges:
	errorFlag = 0
	eText = ""
	if len(b) and b[0] == ".":
		bStyle = re.search(r"\.(.+?)\s{", b)
		bStyle = bStyle[1]
	else:
		if "background-image" in b:
			bFile = re.search(r"\.(\..+?png)", b)
			bFile = bFile[1]
			bName = re.search(r"logos\/(.+?).png", bFile)
			bName = bName[1]

			if bName not in tempBadgeList.values(): # TEST: Is this a duplicate badge?
				tempBadgeList[bStyle] = bName
			else:
				eText = eText + "Badge Error: A badge already exists for "+bName+" but it's named again for "+bStyle+"~"
				errorFlag = 1

			if not os.path.isfile(bFile): # TEST: Does the referenced badge file exist?
				eText = eText + "Badge Error: Trouble finding '"+bFile+"' for '"+bStyle+"'~"
				errorFlag = 1

	if errorFlag:
		debug(eText)

for the_nat in orig_nations:
	errorFlag = 0
	eText = ""

	if len(the_nat) > 5:
		n = the_nat.split(",")
	else:
		continue

	if not len(n) == 9:	# TEST: Does the entry have the correct number of parts?
		eText = eText + "NationError: "+n[0]+" doesn't have the correct number of elements.~"
		errorFlag = 1
	if not re.match(r'^[\w~]+$', n[0]): # TEST: Part 1 should be alphanumerics separated by '~' as needed
		eText = eText + "NationError: '"+the_nat+"' appears to be missing proper aliases at the start.~"
		errorFlag = 1
	if not re.match(r'^[\w\s\.\-&;]+$', n[1]): # TEST: Part 2 should be alphanumerics (+ special chars)
		eText = eText + "NationError: '"+the_nat+"' appears to be missing a proper name.~"
		errorFlag = 1
	if (len(n[2]) != 2) or (not (n[2].isalpha() and n[2].islower())): # TEST: Part 3 should be 2x lowercase letters
		eText = eText + "NationError: '"+the_nat+"' appears to need a correction to the minor style.~"
		errorFlag = 1
	else:
		if n[2] in countByMinorStyle: # TEST: Does the style exist in CSS?
			countByMinorStyle[n[2]] = countByMinorStyle[n[2]] + 1
		else:
			eText = eText + "NationError: '"+the_nat+"' appears to need '"+n[2]+" added to the style sheet.~"
			errorFlag = 1
	if not re.match(r'\w\-.+?', n[3]): # TEST: Does the major style (4th part) fit the template?
		eText = eText + "NationError: '"+the_nat+"' appears to need a correction to the major style.~"
		errorFlag = 1
	else:
		if n[3] not in countByMajorStyle[n[3][0]]: # TEST: Does the style exist in CSS?
			eText = eText + "NationError: '"+the_nat+"' appears to need '"+n[3]+"' added to the style sheet.~"
			errorFlag = 1
			countByMajorStyle[n[3][0]][n[3]] = 1
		else:
			countByMajorStyle[n[3][0]][n[3]] = countByMajorStyle[n[3][0]][n[3]] + 1
	if n[4] == "":
		pass
	elif n[4] != "" and n[4][0] != "x": # TEST: If there's something in the 5th field, it must fit the template.
		eText = eText + "NationError: '"+the_nat+"' appears to need correction to its badge entry.~"
		errorFlag = 1
	elif n[4] not in tempBadgeList.keys(): # TEST: Does the listed flag exist in the badge css?
		eText = eText + "NationError: The badge for '"+n[1]+" ("+n[4]+")' may not be catalogued.~"
		errorFlag = 1
	if not re.match(r'^[\d\.\-]+$', n[5]) or not re.match(r'^[\d\.\-]+$', n[6]): # TEST: Are the 6th and 7th spots floating point co-ordinate pairs?
		eText = eText + "NationError: Check co-ordinates for '"+n[1]+"' (long:"+n[5]+", lat:"+n[6]+")~"
		errorFlag = 1
	if int(n[7]) <= 3 or int(n[7]) >= 15: # TEST: Is the zoom value (8th) an integer between 3 and 15?
		eText = eText + "NationError: Check zoom for '"+n[1]+"' (z = "+str(n[7])+")~"
		errorFlag = 1
	if not re.match(r'^[A-Z]{3}$', n[8]): # TEST: Is the 9th/last part three upper class characters?
		eText = eText + "NationError: Check trigram for "+n[1]+" ("+n[8]+")~"
		errorFlag = 1

	if re.search(r'~', n[0]): # Reduce truename to first in list
		nList = n[0].split("~")
		n[0] = nList[0]

	countryByTri[n[8]] = n[0]
	countryByName[n[0]] = n[8]
	teamByCountry[n[8]] = []
	teamCountByCountry[n[8]] = 0
	if "x" in n[4]:
		nationalBadges[n[0]] = n[4]
		
	if errorFlag:
		debug(eText)

for the_team in orig_teams:
	errorFlag = 0
	eText = ""
	
	if len(the_team) > 5:
		t = the_team.split(",")
	else:
		continue

	if not len(t) == 10: # TEST: Does the entry have the correct number of parts?
		eText = eText + "TeamError: "+t[0]+" doesn't have the correct number of elements. <"+the_team+">~"
		errorFlag = 1
	if "~" in t[0]: # TEST: Do any of the aliases already exist?
		tempTN = t[0].split("~")
		for et in tempTN:
			if et not in tempTeamNames:
				tempTeamNames.append(et)
			else:
				eText = eText + "TeamError: '"+et+"' appears to be a duplicate, from the current line <"+the_team+">~"
				errorFlag = 1
	else:
		if t[0] not in tempTeamNames:
			tempTeamNames.append(t[0])
		else:
			eText = eText + "TeamError: '"+t[0]+"' appears to be a duplicate, from the current line <"+the_team+">~"
			errorFlag = 1
	if not re.match(r'^[\w\s\.\-&;\#\'\/\(\)\d]+$', t[1]): # TEST: Does the 2nd part consist of alphanumerics (+ some punctuation as listed)?
		eText = eText + "TeamError: '"+the_team+"' appears to be missing a proper name.~"
		errorFlag = 1
	if not re.match(r'^[A-Z\d][a-z][a-z][a-z]$', t[2]): # TEXT: Check the pin style (3rd part) settings are OK
		eText = eText + "TeamError: '"+the_team+"' has issues with its pin colours.~"
		errorFlag = 1
	if (len(t[3]) != 2) or (not (t[3].isalpha() and t[3].islower())): # TEST: Does the minor style (4th part) consist of two lower-case letters?
		eText = eText + "TeamError: '"+the_team+"' appears to need a correction to the minor style.~"
		errorFlag = 1
	else:
		if t[3] in countByMinorStyle: # TEST: Is the style listed actually captured in the CSS file?
			countByMinorStyle[t[3]] = countByMinorStyle[t[3]] + 1
		else:
			eText = eText + "TeamError: '"+the_team+"' appears to need '"+t[3]+"' added to the style sheet.~"
			errorFlag = 1
	if not re.match(r'\w\-.+?', t[4]): # TEST: Does the major style (4th part) fit the template?
		eText = eText + "TeamError: '"+the_team+"' appears to need a correction to the major style.~"
		errorFlag = 1
	else:
		if t[4] in countByMajorStyle[t[4][0]]:
			countByMajorStyle[t[4][0]][t[4]] = countByMajorStyle[t[4][0]][t[4]] + 1
		else: # TEST: Does the major style exist in the styles css?
			eText = eText + "TeamError: '"+the_team+"' appears to need '"+t[4]+"' added to the style sheet.~"
			errorFlag = 1
			countByMajorStyle[t[4][0]][t[4]] = 1
	if t[5] == "":
		pass
	elif t[5] != "" and t[5][0] != "x": # TEST: If there's something in the 6th field for the badge, it must fit the template.
		eText = eText + "TeamError: '"+the_team+"' appears to need correction to its badge entry.~"
		errorFlag = 1
	elif t[5] not in tempBadgeList.keys(): # TEST: Does the listed flag exist in the badge css?
		eText = eText + "TeamError: The badge for '"+t[2]+" ("+t[5]+")' may not be cataloged.~"
		errorFlag = 1
	if not re.match(r'^[\d\.\-]+$', t[6]) or not re.match(r'^[\d\.\-]+$', t[7]): # TEST: Are the 6th and 7th spots floating point co-ordinate pairs?
		eText = eText + "TeamError: Check co-ordinates for '"+t[2]+"' (long:"+t[6]+", lat:"+t[7]+") Orig line: "+the_team+"~"
		errorFlag = 1
	if not re.match(r'^[\w\s\.\'\#\/\-&;]+$', t[8]): # TEST: Does the 9th part consist of alphanumerics (+ some punctuation as listed)?
		eText = eText + "TeamError: '"+the_team+"' appears to be missing a place name.~"
		errorFlag = 1
	if not re.match(r'^[A-Z]{3}$', t[9]): # TEST: Is the 10th/last part three upper case characters?
		eText = eText + "TeamError: Check trigram for "+t[2]+" ("+t[9]+")~"
		errorFlag = 1

	if "~" in t[0]:
		tList = t[0].split("~")
		t[0] = tList[0]
	
	try:
		teamByCountry[t[9]].append(t[0])
	except KeyError:
		print("Problem (INT or unknown Trigramme): "+the_team)
	
	teamCountByCountry[t[9]] = teamCountByCountry[t[9]] + 1	
	if countryByTri[t[9]] not in teamBadgesByCountry:
		teamBadgesByCountry[countryByTri[t[9]]] = []
	if "x" in t[5]:
		if countryByTri[t[9]] not in teamBadgesCountByCountry:
			teamBadgesCountByCountry[countryByTri[t[9]]] = 0
		teamBadgesByCountry[countryByTri[t[9]]].append(t[0])
		teamBadgesCountByCountry[countryByTri[t[9]]] = teamBadgesCountByCountry[countryByTri[t[9]]] + 1

	totalTeams = totalTeams + 1
	
	if errorFlag:
		debug(eText)

tempTeamNames = []
totalCountries = len(countryByTri)
natsWBadges = sorted(teamBadgesByCountry.keys())

Out["teamBadgesCountByCountry"] = teamBadgesCountByCountry
Out["champs"] = Champs
Out["errorList"] = errorList
Out["totalCountries"] = totalCountries
Out["totalTeams"] = totalTeams
Out["monNats"] = monitored_Nations
Out["countryByTri"] = countryByTri
Out["countryByName"] = countryByName
Out["countMinor"] = countByMinorStyle
Out["countMajor"] = countByMajorStyle
Out["teamByCountry"] = teamByCountry
Out["teamCountByCountry"] = teamCountByCountry
Out["nationalBadges"] = nationalBadges
Out["teamBadgesByCountry"] = {}
for nB in natsWBadges:
	if len(teamBadgesByCountry[nB]) > 0:
		Out["teamBadgesByCountry"][nB] = teamBadgesByCountry[nB]

with open(the_oldfile, 'w') as j:
	json.dump(Out, j, indent='\t')

exit(0)

