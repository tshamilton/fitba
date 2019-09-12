import os
import re
import csv
import json

DEBUG=1
Champs = {}
countByCountry = {}
countByMajorStyle = {}
countByMinorStyle = {}
countryByName = {}
countryByTri = {}
listByCountry = {}
tempBadgeList = {}

tempTeamNames = []
errorList = []

the_nations = "./config/nations.csv"
the_teams = "./config/teams.csv"
the_comps = "./config/comps.csv"
the_styles = "./css/style.css"
the_badges = "./css/badge.css"
the_oldfile = "./config/stats.json"

def debug(message):
	global DEBUG
	
	if DEBUG:
		print(message)

'''
#Prepare
Set up JSON framework
Initialise dictionaries
Done - List input files
#Get Current data 
Done - Open the old json file?
	x - Feed contents of "Champs" into string for later use.
Done - Open the css file?
	x - Can I read the style names into a list?
	x - Initialise css style name in countByStyle list
Done - Open the competitions file?
Done - Open the badges file?
	x - Record all styles starting with '.' but longer than one char long
	x - Note attached file name
		x - Check file exists
		x - Check for duplicate references
Done - Open the nations file?
	#Analyze incorrect entries
		#Add to stats
	Count array length (9)
	Check [0-1] are strings
	Check [0] is lower case
	Check [2-3] are color shorthands
		Check minor exists in countByStyle
		Check major exists in css list
	Check if [4] starts with an 'x'
		If [4] complies, does it exist in the badge css list
	Check [5-6] are floats
	Check [7] is a integer between 2-15
	Check [8] is 3 chars long and all caps
		If all checks pass
			Add name and tri to sortCByName list
			Add tri and name to sortCByTri list
			Increment minorCount
			Increment majorCount
			Set countByCountry dict entry to 0
			Initialise listByCountry
			Initialise badgeByCountry
			Add name to badgeByCountry
		When something doesn't work report line number and whole line
x - Open the teams file?
	#Analyze incorrect entries
		#Add to stats
	Count array length (10)
	Check [0-1] are strings
	Check [0] is lower case
	Check [2-5] are color shorthands
		Check minor exists in countByStyle
		Check major exists in css list
	Check if [6] starts with an 'x'
		If [6] complies, does it exist in the badge css list
	Check [7-8] are decimals
	Check [9] is a string
	Check [10] is 3 chars long and all caps
		If all checks pass
			Increment countByCountry
			Add name to listByCountry
			Increment minorCount
			Increment majorCount
			Increment badgeCount
			Add name to badgeByCountry
	When something doesn't work report line number and whole line
x - If I can't open a file, report the file
'''
if os.path.isfile(the_oldfile):
	debug("Can open current JSON")
	with open(the_oldfile) as f:
		orig_oldfile = json.load(f)
		Champs = orig_oldfile["Champs"]
else:
	debug("FileError: Can't open current JSON file")
	exit(1)

if os.path.isfile(the_comps):
	debug("Can open comps csv")
	with open(the_comps) as f:
		orig_comps = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open comps file")
	exit(1)

if os.path.isfile(the_styles):
	debug("Can open styles css")
	with open(the_styles) as f:
		orig_styles = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open style file")
	exit(1)
for c in orig_styles:
	if len(c) and c[0] == ".":
		cStyle = re.search(r"\.(.+?)\s{", c)
		cStyle = cStyle[1]
		if len(cStyle) == 2:
			countByMinorStyle[cStyle] = 0
		elif re.search(r"^.\-", cStyle):
			countByMajorStyle[cStyle] = 0

if os.path.isfile(the_badges):
	debug("Can open badges csv")
	with open(the_badges) as f:
		orig_badges = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open badges file")
	exit(1)
for b in orig_badges:
	if b[0] == ".":
		bStyle = re.search(r"\.(.+?)\s{", b)
		bStyle = bStyle[1]
	else:
		if "background-image" in b:
			bFile = re.search(r"\.(\..+?png)", b)
			bFile = bFile[1]
			bName = re.search(r"logos\/(.+?).png", bFile)
			bName = bName[1]

			if bName not in tempBadgeList.values():
				tempBadgeList[bStyle] = bName
			else:
				text = "BadgeError: A badge already exists for "+bName+" but it's named again for "+bStyle
				debug("\t"+text)
				errorList.append(text)

			if not os.path.isfile(bFile):
				text = "BadgeError: Trouble finding '"+bFile+"' for '"+bStyle+"'"
				debug("\t"+text)
				errorList.append(text)

if os.path.isfile(the_nations):
	debug("Can open nations csv")
	with open(the_nations) as f:
		orig_nations = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open nations file")
	exit(1)
for the_nat in orig_nations:
	n = the_nat.split(",")
	if not len(n) == 9:
		text = "NationError: "+n[0]+" doesn't have the correct number of elements."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\w~]+$', n[0]):
		text = "NationError: '"+the_nat+"' appears to be missing proper aliases at the start."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\w\s\.\-&;]+$', n[1]):
		text = "NationError: '"+the_nat+"' appears to be missing a proper name."
		debug("\t"+text)
		errorList.append(text)
	if (len(n[2]) != 2) or (not (n[2].isalpha() and n[2].islower())):
		text = "NationError: '"+the_nat+"' appears to need a correction to the minor style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if n[2] in countByMinorStyle:
			countByMinorStyle[n[2]] = countByMinorStyle[n[2]] + 1
		else:
			text = "NationError: '"+the_nat+"' appears to need '"+n[2]+" added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if not re.match(r'\w\-.+?', n[3]):
		text = "NationError: '"+the_nat+"' appears to need a correction to the major style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if n[3] in countByMajorStyle:
			countByMajorStyle[n[3]] = countByMajorStyle[n[3]] + 1
		else:
			text = "NationError: '"+the_nat+"' appears to need '"+n[3]+" added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if n[4] == "":
		pass
	elif n[4] != "" and n[4][0] != "x":
		text = "NationError: '"+the_nat+"' appears to need correction to its badge entry."
		debug("\t"+text)
		errorList.append(text)
	elif n[4] not in tempBadgeList.keys():
		text = "NationError: The badge for '"+n[1]+" ("+n[4]+")' may not be catalogued."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\d\.\-]+$', n[5]) or not re.match(r'^[\d\.\-]+$', n[6]):
		text = "NationError: Check co-ordinates for '"+n[1]+"' (long:"+n[5]+", lat:"+n[6]+")"
		debug("\t"+text)
		errorList.append(text)
	if int(n[7]) <= 3 or int(n[7]) >= 15:
		text = "NationError: Check zoom for '"+n[1]+"' (z = "+str(n[7])+")"
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[A-Z]{3}$', n[8]):
		text = "NationError: Check trigram for "+n[1]+" ("+n[8]+")"
		debug("\t"+text)
		errorList.append(text)

	if re.match("~", n[0]):
		nList = n[0].split("~")
		n[0] = nList[0]
	countryByName[n[0]] = n[8]
	countryByTri[n[8]] = n[0]
	countByMinorStyle[n[2]] = countByMinorStyle[n[2]] + 1
	countByMajorStyle[n[3]] = countByMajorStyle[n[3]] + 1
	countByCountry[n[8]] = 0
	listByCountry[n[8]] = {}

if os.path.isfile(the_teams):
	debug("Can open teams csv")
	with open(the_teams) as f:
		orig_teams = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open teams file")
	exit(1)
for the_team in orig_teams:
	t = the_team.split(",")
	if not len(t) == 10:
		text = "TeamError: "+n[0]+" doesn't have the correct number of elements."
		debug("\t"+text)
		errorList.append(text)
	if "~" in t[0]:
		t[0] = t[0].split("~")
		for x in t[0]:
			if x not in tempTeamNames:
				tempTeamNames.append(x)
			else:
				text = "TeamError: '"+x+"' has already been added to the list."
				debug("\t"+text)
				errorList.append(text)
			pass


exit(0)