import re
import os
import time
import requests

def debug(message):
	DEBUG = 1
	
	if DEBUG:
		print(message)

def main():
	DEBUG = 1
	css_file = './css/style.css'
	team_file = './config/teams.csv'
	nat_file = './config/nations.csv'
	the_output = []
	css = []

	css_list = open(css_file, "r")
	debug("Reading in css file.")
	for c in css_list:
		if len(c) < 5 or c[0] != ".":
			continue

		st = re.compile("^\.(.+?)\s")
		s = st.match(c)
		try:
			css.append(s.group(1))
		except AttributeError:
			debug("Issue found with line.\n '"+c+"'")

	css_list.close
	debug("Existing CSS list compiled. "+str(len(css))+" entries.")

	debug("Reading in team list.")

	team_list = open(team_file, "r")
	for this_team in team_list:
		t = this_team.split(",")
		if len(t) != 10:
			debug(t[1]+" has the wrong number of elements.")

"""
Here be the place
"""

if os.path.isfile('./config/wfh.txt'): 
	DEBUG = 1
else:
	DEBUG = 0

if __name__ == "__main__":
	main()
