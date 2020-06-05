import re

the_teams = "./config/teams.csv"
diacs = []

with open(the_teams) as f:
	orig_teams = f.read().splitlines()
	f.close()

for the_team in orig_teams:
	errorFlag = 0
	eText = ""

	samp = re.findall(r'&(.+?);', the_team)

	for t in samp:
		if t not in diacs:
			diacs.append(t)	

diacs.sort(key=str.lower)
for d in diacs:
	print("<tr><td class=\"text-center\">&"+d+";</td><td class=\"text-left\"></td><td class=\"text-left\">&amp;"+d+";</td></tr>")


## Suppose we have a text with many email addresses
# str = 'purple alice@google.com, blah monkey bob@abc.com blah dishwasher'
#
## Here re.findall() returns a list of all the found email strings
# emails = re.findall(r'[\w\.-]+@[\w\.-]+', str) ## ['alice@google.com', 'bob@abc.com']
# for email in emails:
# # do something with each found email string
#  print email