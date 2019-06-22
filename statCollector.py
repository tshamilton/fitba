import os
import re
import csv
import json

def tally_colours(mN, mJ):
	global Stats

	if mN in Stats["Colours"]["minor"]:
		Stats["Colours"]["minor"][mN] += 1
	else:
		Stats["Colours"]["minor"][mN] = 1
		Stats["Colours"]["minor"]["sortedby"][mN] = mN[1]+mN[0]

	if "x-" in mJ:
		if mJ in Stats["Colours"]["plain"]:
			Stats["Colours"]["plain"][mJ] += 1
		else:
			Stats["Colours"]["plain"][mJ] = 1
			Stats["Colours"]["plain"]["sortedby"][mJ] = mJ[3]+mJ[2]

	elif "s-" in mJ:
		if mJ in Stats["Colours"]["stripes"]:
			Stats["Colours"]["stripes"][mJ] += 1
		else:
			Stats["Colours"]["stripes"][mJ] = 1
			Stats["Colours"]["stripes"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "b-" in mJ:
		if mJ in Stats["Colours"]["bands"]:
			Stats["Colours"]["bands"][mJ] += 1
		else:
			Stats["Colours"]["bands"][mJ] = 1
			Stats["Colours"]["bands"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "h-" in mJ:
		if mJ in Stats["Colours"]["hoops"]:
			Stats["Colours"]["hoops"][mJ] += 1
		else:
			Stats["Colours"]["hoops"][mJ] = 1
			Stats["Colours"]["hoops"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "e-" in mJ:
		if mJ in Stats["Colours"]["edges"]:
			Stats["Colours"]["edges"][mJ] += 1
		else:
			Stats["Colours"]["edges"][mJ] = 1
			Stats["Colours"]["edges"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "o-" in mJ:
		if mJ in Stats["Colours"]["offsets"]:
			Stats["Colours"]["offsets"][mJ] += 1
		else:
			Stats["Colours"]["offsets"][mJ] = 1
			Stats["Colours"]["offsets"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "v-" in mJ:
		if mJ in Stats["Colours"]["halves"]:
			Stats["Colours"]["halves"][mJ] += 1
		else:
			Stats["Colours"]["halves"][mJ] = 1
			Stats["Colours"]["halves"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	elif "z-" in mJ:
		if mJ in Stats["Colours"]["others"]:
			Stats["Colours"]["others"][mJ] += 1
		else:
			Stats["Colours"]["others"][mJ] = 1
			Stats["Colours"]["others"]["sortedby"][mJ] = mJ[3:]+mJ[2]

	Stats["Colours"]["minor"]["total"] = len(Stats["Colours"]["minor"]) - 2
	Stats["Colours"]["plain"]["total"] = len(Stats["Colours"]["plain"]) - 2
	Stats["Colours"]["stripes"]["total"] = len(Stats["Colours"]["stripes"]) - 2
	Stats["Colours"]["bands"]["total"] = len(Stats["Colours"]["bands"]) - 2
	Stats["Colours"]["hoops"]["total"] = len(Stats["Colours"]["hoops"]) - 2
	Stats["Colours"]["edges"]["total"] = len(Stats["Colours"]["edges"]) - 2
	Stats["Colours"]["offsets"]["total"] = len(Stats["Colours"]["offsets"]) - 2
	Stats["Colours"]["halves"]["total"] = len(Stats["Colours"]["halves"]) - 2
	Stats["Colours"]["others"]["total"] = len(Stats["Colours"]["others"]) - 2

the_nations = "./config/nations.csv"
the_teams = "./config/teams.csv"
the_comps = "./config/comps.csv"

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
		"others": { 
			"total": 0,
			"sortedby": {}
		}
	}
}

Team = {}

with open(the_nations, 'r') as n:
	#name,Display,minor,major,baj,lat,lng,zoom,TRI
	nats = csv.reader(n)
	for row in nats:
		id = row[0].split("~")
		Stats["Nations"]["total"] += 1
		Stats["Nations"]["by_tri"][row[8]] = id[0]
		Stats["Nations"]["by_name"][id[0]] = row[8]
		tally_colours(row[2], row[3])

with open(the_teams, 'r') as t:
	#aagent,AA Gent,Gbwb,bw,b-bbw,x042,51.016111,3.734167,Ghent,BEL
	teams = csv.reader(t)
	for row in teams:
		Stats["Teams"]["total"] += 1
		tally_colours(row[3], row[4])

with open(the_comps, 'r') as c:
	comps = csv.reader(c)
	for row in comps:
		if row[0] == "N":
			Stats["Nations"]["by_pref"][row[1]] = row[3]

with open('./config/stats.json', 'w', encoding='utf-8') as outfile:  
    json.dump(Stats, outfile, ensure_ascii=False, sort_keys=True, indent=4)