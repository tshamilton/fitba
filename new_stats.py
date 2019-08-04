import os
import re
import csv
import json

def debug(message):
	global DEBUG
	
	if DEBUG:
		print(message)

# New statistics python script
# 3.0 Can I open the css file?
#	3.1 Can I read the style names into a list?
# 1.0 Can I open the teams file?
#	1.1 Can I go line by line and analyze incorrect entries
# 2.0 Can I open the nations file?
# 4.0 Can I open the competitions file?
# 5.0 Can I open the badges file?
# 6.0 Can I open the old json file?

DEBUG = 0

Stats = {
	"Nations": { 
		"total": 0,
		"by_pref": {},
		"by_name": {},
		"by_tri": {}
	},
	"Teams": { "total": 0 },
	"Colours": {
		"minor": { 
			"total": 0,
			"sortedby": {}
		},
		"plain": { 
			"total": 0,
			"sortedby": {}
		},
		"bands": { 
			"total": 0,
			"sortedby": {}
		},
		"stripes": { 
			"total": 0,
			"sortedby": {}
		},
		"hoops": { 
			"total": 0,
			"sortedby": {}
		},
		"edges": { 
			"total": 0,
			"sortedby": {}
		},
		"offsets": { 
			"total": 0,
			"sortedby": {}
		},
		"halves": { 
			"total": 0,
			"sortedby": {}
		},
		"sashes": {
			"total": 0,
			"sortedby": {}
		},
		"others": { 
			"total": 0,
			"sortedby": {}
		}
	},
	"Badges": {},
	"Champs": {}
}

the_nations = "./config/nations.csv"
the_teams = "./config/teams.csv"
the_comps = "./config/comps.csv"
the_styles = "./css/style.css"
the_badges = "./css/badge.css"
the_oldfile = "./config/stats.json"

with open(the_nations) as f:
	orig_nations = f.read().splitlines()
	f.close()

with open(the_teams) as f:
	orig_teams = f.read().splitlines()

	f.close()

with open(the_comps) as f:
	orig_comps = f.read().splitlines()
	f.close()

with open(the_styles) as f:
	orig_styles = f.read().splitlines()
	f.close()

with open(the_badges) as f:
	orig_badges = f.read().splitlines()
	f.close()

with open(the_oldfile) as f:
	orig_oldfile = json.load(f)
	Stats["Champs"] = orig_oldfile["Champs"]

styles = []

for s in orig_styles:
	if len(s) > 5 and s[0] == ".":
		if s[2] == "-" or re.match("^\...\s", s):
			this = s.split()
			styles.append(this[0])

for this_team in orig_teams:
	tm = this_team.split(",")
	
bleh = 1