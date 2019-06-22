import os
import re
import csv
import json

def tally_colours(mN, mJ):
	global Stats
	Stats["Colours"]["minor"]["total"] += 1
	if mN in Stats["Colours"]["minor"]:
		Stats["Colours"]["minor"][mN] += 1
	else:
		Stats["Colours"]["minor"][mN] = 1
	
	if "x-" in mJ:
		Stats["Colours"]["plain"]["total"] += 1
		if mJ in Stats["Colours"]["plain"]:
			Stats["Colours"]["plain"][mJ] += 1
		else:
			Stats["Colours"]["plain"][mJ] = 1
	elif "s-" in mJ:
		Stats["Colours"]["stripes"]["total"] += 1
		if mJ in Stats["Colours"]["stripes"]:
			Stats["Colours"]["stripes"][mJ] += 1
		else:
			Stats["Colours"]["stripes"][mJ] = 1
	elif "b-" in mJ:
		Stats["Colours"]["bands"]["total"] += 1
		if mJ in Stats["Colours"]["bands"]:
			Stats["Colours"]["bands"][mJ] += 1
		else:
			Stats["Colours"]["bands"][mJ] = 1
	elif "h-" in mJ:
		Stats["Colours"]["hoops"]["total"] += 1
		if mJ in Stats["Colours"]["hoops"]:
			Stats["Colours"]["hoops"][mJ] += 1
		else:
			Stats["Colours"]["hoops"][mJ] = 1
	elif "e-" in mJ:
		Stats["Colours"]["edges"]["total"] += 1
		if mJ in Stats["Colours"]["edges"]:
			Stats["Colours"]["edges"][mJ] += 1
		else:
			Stats["Colours"]["edges"][mJ] = 1
	elif "o-" in mJ:
		Stats["Colours"]["offsets"]["total"] += 1
		if mJ in Stats["Colours"]["offsets"]:
			Stats["Colours"]["offsets"][mJ] += 1
		else:
			Stats["Colours"]["offsets"][mJ] = 1
	elif "v-" in mJ:
		Stats["Colours"]["halves"]["total"] += 1
		if mJ in Stats["Colours"]["halves"]:
			Stats["Colours"]["halves"][mJ] += 1
		else:
			Stats["Colours"]["halves"][mJ] = 1
	elif "z-" in mJ:
		Stats["Colours"]["others"]["total"] += 1
		if mJ in Stats["Colours"]["others"]:
			Stats["Colours"]["others"][mJ] += 1
		else:
			Stats["Colours"]["others"][mJ] = 1

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
		"minor": { "total": 0 },
		"plain": { "total": 0 },
		"bands": { "total": 0 },
		"stripes": { "total": 0 },
		"hoops": { "total": 0 },
		"edges": { "total": 0 },
		"offsets": { "total": 0 },
		"halves": { "total": 0 },
		"others": { "total": 0 }
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