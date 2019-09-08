import os
import re
import csv
import json

DEBUG=1
Stats = {}

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
x - List input files
#Get Current data 
x - Open the old json file?
	Feed contents of "Champs" into string for later use.
x - Open the css file?
	Can I read the style names into a list?
	Initialise css style name in countByStyle list
x - Open the competitions file?
x - Open the badges file?
	x - Record all lines starting with '.'
	Note attached file name
		Check file exists
x - Open the nations file?
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
		Stats["Champs"] = orig_oldfile["Champs"]
else:
	debug("Can't open current JSON file")
	exit(1)

if os.path.isfile(the_nations):
	debug("Can open nations csv")
	with open(the_nations) as f:
		orig_nations = f.read().splitlines()
		f.close()
else:
	debug("Can't open nations file")
	exit(1)

if os.path.isfile(the_teams):
	debug("Can open teams csv")
	with open(the_teams) as f:
		orig_teams = f.read().splitlines()
		f.close()
else:
	debug("Can't open teams file")
	exit(1)

if os.path.isfile(the_comps):
	debug("Can open comps csv")
	with open(the_comps) as f:
		orig_comps = f.read().splitlines()
		f.close()
else:
	debug("Can't open comps file")
	exit(1)

if os.path.isfile(the_styles):
	debug("Can open styles css")
	with open(the_styles) as f:
		orig_styles = f.read().splitlines()
		f.close()
else:
	debug("Can't open style file")
	exit(1)

if os.path.isfile(the_badges):
	debug("Can open badges csv")
	with open(the_badges) as f:
		orig_badges = f.read().splitlines()
		f.close()
else:
	debug("Can't open badges file")
	exit(1)

for b in orig_badges:
	if b[0] == ".":
		print(b)

exit(0)