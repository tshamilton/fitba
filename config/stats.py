import os
import re
import csv
import json

DEBUG=1
Stats = {}
Stats["Champs"] = {}
Stats["Errors"] = []
Champs = {}
countByCountry = {}
countByMajorStyle = {}
countByMinorStyle = {}
countryByName = {}
countryByTri = {}
listByCountry = {}
tempBadgeList = {}

tempTeamNames = []
tempCoords = []
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
	x - Count array length (9)
	x - Check [0-1] are strings
	x - Check [0] is lower case
	x - Check [2-3] are color shorthands
		x - Check minor exists in countByStyle
		x - Check major exists in css list
	x - Check if [4] starts with an 'x'
		x - If [4] complies, does it exist in the badge css list
	x - Check [5-6] are floats
	x - Check [7] is a integer between 2-15
	x - Check [8] is 3 chars long and all caps
	x - If all checks pass
			x - Add name and tri to sortCByName list
			x - Add tri and name to sortCByTri list
			x - Increment minorCount
			x - Increment majorCount
			x - Set countByCountry dict entry to 0
			x - Initialise listByCountry
			x - Initialise badgeByCountry
			x - Add name to badgeByCountry
		x - When something doesn't work report line number and whole line
x - Open the teams file?
	#Analyze incorrect entries
		#Add to stats
	x - Count array length (10)
	x - Check [0-1] are strings
	x - Check [0] is lower case
	x - Check [2-5] are color shorthands
		x - Check minor exists in countByStyle
		x - Check major exists in css list
	x - Check if [6] starts with an 'x'
		x - If [6] complies, does it exist in the badge css list
	x - Check [7-8] are decimals
			Check if [7-8] have duplicates
	x - Check [9] is a string
	x - Check [10] is 3 chars long and all caps
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
if os.path.isfile(the_oldfile): # TEST: Does the current JSON file exist and can it be opened?
	debug("Can open current JSON")
	with open(the_oldfile) as f:
		orig_oldfile = json.load(f)
		Stats["Champs"] = orig_oldfile["Champs"]
else:
	debug("FileError: Can't open current JSON file")
	exit(1)

if os.path.isfile(the_comps): # TEST: Does the competition csv exist and can it be opened?
	debug("Can open comps csv")
	with open(the_comps) as f:
		orig_comps = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open comps file")
	exit(1)

if os.path.isfile(the_styles): # TEST: Does the styles css exist and can it be opened?
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

if os.path.isfile(the_badges): # TEST: Does the badge css exist and can it be opened?
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

			if bName not in tempBadgeList.values(): # TEST: Is this a duplicate badge?
				tempBadgeList[bStyle] = bName
			else:
				text = "BadgeError: A badge already exists for "+bName+" but it's named again for "+bStyle
				debug("\t"+text)
				errorList.append(text)

			if not os.path.isfile(bFile): # TEST: Does the referenced badge file exist?
				text = "BadgeError: Trouble finding '"+bFile+"' for '"+bStyle+"'"
				debug("\t"+text)
				errorList.append(text)

if os.path.isfile(the_nations): # TEST: Does the nations csv exist and can it be opened?
	debug("Can open nations csv")
	with open(the_nations) as f:
		orig_nations = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open nations file")
	exit(1)
for the_nat in orig_nations:
	n = the_nat.split(",")
	if not len(n) == 9:	# TEST: Does the entry have the correct number of parts?
		text = "NationError: "+n[0]+" doesn't have the correct number of elements."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\w~]+$', n[0]): # TEST: Does the 1st part consist of alphanumerics separated by '~' where necessary?
		text = "NationError: '"+the_nat+"' appears to be missing proper aliases at the start."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\w\s\.\-&;]+$', n[1]): # TEST: Does the 2nd part consist of alphanumerics (+ some punctuation as listed)?
		text = "NationError: '"+the_nat+"' appears to be missing a proper name."
		debug("\t"+text)
		errorList.append(text)
	if (len(n[2]) != 2) or (not (n[2].isalpha() and n[2].islower())): # TEST: Does the minor style (3rd part) consist of two lower-case letters?
		text = "NationError: '"+the_nat+"' appears to need a correction to the minor style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if n[2] in countByMinorStyle: # TEST: Is the style listed actually captured in the CSS file?
			countByMinorStyle[n[2]] = countByMinorStyle[n[2]] + 1
		else:
			text = "NationError: '"+the_nat+"' appears to need '"+n[2]+" added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if not re.match(r'\w\-.+?', n[3]): # TEST: Does the major style (4th part) fit the template?
		text = "NationError: '"+the_nat+"' appears to need a correction to the major style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if n[3] in countByMajorStyle:
			countByMajorStyle[n[3]] = countByMajorStyle[n[3]] + 1
		else: # TEST: Does the major style exist in the styles css?
			text = "NationError: '"+the_nat+"' appears to need '"+n[3]+" added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if n[4] == "":
		pass
	elif n[4] != "" and n[4][0] != "x": # TEST: If there's something in the 5th field, it must fit the template.
		text = "NationError: '"+the_nat+"' appears to need correction to its badge entry."
		debug("\t"+text)
		errorList.append(text)
	elif n[4] not in tempBadgeList.keys(): # TEST: Does the listed flag exist in the badge css?
		text = "NationError: The badge for '"+n[1]+" ("+n[4]+")' may not be catalogued."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\d\.\-]+$', n[5]) or not re.match(r'^[\d\.\-]+$', n[6]): # TEST: Are the 6th and 7th spots floating point co-ordinate pairs?
		text = "NationError: Check co-ordinates for '"+n[1]+"' (long:"+n[5]+", lat:"+n[6]+")"
		debug("\t"+text)
		errorList.append(text)
	if int(n[7]) <= 3 or int(n[7]) >= 15: # TEST: Is the zoom value (8th) an integer between 3 and 15?
		text = "NationError: Check zoom for '"+n[1]+"' (z = "+str(n[7])+")"
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[A-Z]{3}$', n[8]): # TEST: Is the 9th/last part three upper class characters?
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
	listByCountry[n[8]] = []

if os.path.isfile(the_teams): # TEST: Does the teams csv exist and can it be opened?
	debug("Can open teams csv")
	with open(the_teams) as f:
		orig_teams = f.read().splitlines()
		f.close()
else:
	debug("FileError: Can't open teams file")
	exit(1)
for the_team in orig_teams:
	if len(the_team) < 5:
		pass
	t = the_team.split(",")
	if not len(t) == 10: # TEST: Does the entry have the correct number of parts?
		text = "TeamError: "+t[0]+" doesn't have the correct number of elements.\n<"+the_team+">\n"
		debug("\t"+text)
		errorList.append(text)
	if "~" in t[0]: # TEST: Do any of the aliases already exist?
		tempTN = t[0].split("~")
		for et in tempTN:
			if et not in tempTeamNames:
				tempTeamNames.append(et)
			else:
				text = "TeamError: '"+et+"' appears to be a duplicate, from the current line <"+the_team+">"
				debug("\t"+text)
				errorList.append(text)
	else:
		if t[0] not in tempTeamNames:
			tempTeamNames.append(t[0])
		else:
			text = "TeamError: '"+t[0]+"' appears to be a duplicate, from the current line <"+the_team+">"
			debug("\t"+text)
			errorList.append(text)
	if not re.match(r'^[\w\s\.\-&;\#\'\/\(\)\d]+$', t[1]): # TEST: Does the 2nd part consist of alphanumerics (+ some punctuation as listed)?
		text = "TeamError: '"+the_team+"' appears to be missing a proper name."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[A-Z\d][a-z][a-z][a-z]$', t[2]): # TEXT: Check the pin style (3rd part) settings are OK
		text = "TeamError: '"+the_team+"' has issues with its pin colours."
		debug("\t"+text)
		errorList.append(text)
	if (len(t[3]) != 2) or (not (t[3].isalpha() and t[3].islower())): # TEST: Does the minor style (4th part) consist of two lower-case letters?
		text = "TeamError: '"+the_team+"' appears to need a correction to the minor style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if t[3] in countByMinorStyle: # TEST: Is the style listed actually captured in the CSS file?
			countByMinorStyle[t[3]] = countByMinorStyle[t[3]] + 1
		else:
			text = "TeamError: '"+the_team+"' appears to need '"+t[3]+"' added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if not re.match(r'\w\-.+?', t[4]): # TEST: Does the major style (4th part) fit the template?
		text = "TeamError: '"+the_team+"' appears to need a correction to the major style."
		debug("\t"+text)
		errorList.append(text)
	else:
		if t[4] in countByMajorStyle:
			countByMajorStyle[t[4]] = countByMajorStyle[t[4]] + 1
		else: # TEST: Does the major style exist in the styles css?
			text = "TeamError: '"+the_team+"' appears to need '"+t[4]+"' added to the style sheet."
			debug("\t"+text)
			errorList.append(text)
	if t[5] == "":
		pass
	elif t[5] != "" and t[5][0] != "x": # TEST: If there's something in the 6th field for the badge, it must fit the template.
		text = "TeamError: '"+the_team+"' appears to need correction to its badge entry."
		debug("\t"+text)
		errorList.append(text)
	elif t[5] not in tempBadgeList.keys(): # TEST: Does the listed flag exist in the badge css?
		text = "TeamError: The badge for '"+t[2]+" ("+t[5]+")' may not be cataloged."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[\d\.\-]+$', t[6]) or not re.match(r'^[\d\.\-]+$', t[7]): # TEST: Are the 6th and 7th spots floating point co-ordinate pairs?
		text = "TeamError: Check co-ordinates for '"+t[2]+"' (long:"+t[6]+", lat:"+t[7]+") Orig line: "+the_team
		debug("\t"+text)
		errorList.append(text)
	elif (t[6]+","+t[7]) in tempCoords: # TEST: Are there any other teams who already use these co-ordinates?
		text = "TeamError: "+t[0]+" appears to have duplicate co-ordinates (x:"+t[6]+","+t[7]+")"
		debug("\t"+text)
		errorList.append(text)
	else:
		tempCoords.append(t[6]+","+t[7])
	if not re.match(r'^[\w\s\.\'\#\/\-&;]+$', t[8]): # TEST: Does the 9th part consist of alphanumerics (+ some punctuation as listed)?
		text = "TeamError: '"+the_team+"' appears to be missing a place name."
		debug("\t"+text)
		errorList.append(text)
	if not re.match(r'^[A-Z]{3}$', t[9]): # TEST: Is the 10th/last part three upper case characters?
		text = "TeamError: Check trigram for "+t[2]+" ("+t[9]+")"
		debug("\t"+text)
		errorList.append(text)

	if re.match("~", t[0]):
		tList = t[0].split("~")
		t[0] = tList[0]
	try:
		countByMinorStyle[t[3]] = countByMinorStyle[t[3]] + 1
	except KeyError: # TEST: Does the minor style not yet exist in css?
		text = "TeamError: Minor style "+t[3]+" not listed in css."
		debug("\t"+text)
		errorList.append(text)
	try:
		countByMajorStyle[t[4]] = countByMajorStyle[t[4]] + 1
	except KeyError: # TEST: Does the major style not yet exist in css?
		text = "TeamError: Major style "+t[4]+" not listed in css."
		debug("\t"+text)
		errorList.append(text)

	countByCountry[t[9]] = countByCountry[t[9]] + 1
	listByCountry[t[9]].append(t[0])

Stats["Errors"] = errorList

with open('base.json', 'w') as json_file:
	json.dump(Stats, json_file)

exit(0)
