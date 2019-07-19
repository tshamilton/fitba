import re
import os
import time
import requests

def pluck(re_s, source):
	res = re.search(re_s, source, re.IGNORECASE)

	if res is not None:
		return res[1]
	else:
		return ""

def debug(message):
	global DEBUG
	
	if DEBUG:
		print(message)

def get_data(the_url):
	incoming = requests.get(the_url)
	cinput = incoming.content
	return cinput

def cleanWords(text):
	txt = re.sub("[\s|\'|\.|\-|\/|\°|\(|\)]", "", text)
	return txt

def washText(the_text, context, out="n"):
	whatImean = "" * 255
	whatImeanH = "" * 255
	whatImean[194] = "" * 255
	whatImeanH[194] = "" * 255
	whatImean[194][160] = " "
	whatImeanH[194][160] = " "
	whatImean[194][173] = "-"
	whatImeanH[194][173] = "-"
	whatImean[194][180] = "'"
	whatImeanH[194][180] = "'"
	whatImean[195] = "" * 255
	whatImeanH[195] = "" * 255
	whatImean[195][128] = "A"
	whatImeanH[195][128] = "&Agrave;"
	whatImean[195][129] = "A"
	whatImeanH[195][129] = "&Aacute;"
	whatImean[195][130] = "A"
	whatImeanH[195][130] = "&Acirc;"
	whatImean[195][131] = "A"
	whatImeanH[195][131] = "&Atilde;"
	whatImean[195][132] = "A"
	whatImeanH[195][132] = "&Auml;"
	whatImean[195][133] = "A"
	whatImeanH[195][133] = "&Aring;"
	whatImean[195][134] = "Ae"
	whatImeanH[195][134] = "&AElig;"
	whatImean[195][135] = "C"
	whatImeanH[195][135] = "&Ccedil;"
	whatImean[195][136] = "E"
	whatImeanH[195][136] = "&Egrave;"
	whatImean[195][137] = "E"
	whatImeanH[195][137] = "&Eacute;"
	whatImean[195][138] = "E"
	whatImeanH[195][138] = "&Ecirc;"
	whatImean[195][139] = "E"
	whatImeanH[195][139] = "&Euml;"
	whatImean[195][140] = "I"
	whatImeanH[195][140] = "&Igrave;"
	whatImean[195][141] = "I"
	whatImeanH[195][141] = "&Iacute;"
	whatImean[195][142] = "I"
	whatImeanH[195][142] = "&Icirc;"
	whatImean[195][143] = "I"
	whatImeanH[195][143] = "&Iuml;"
	whatImean[195][144] = "D"
	whatImeanH[195][144] = "&ETH;"
	whatImean[195][145] = "N"
	whatImeanH[195][145] = "&Ntilde;"
	whatImean[195][146] = "O"
	whatImeanH[195][146] = "&Ograve;"
	whatImean[195][147] = "O"
	whatImeanH[195][147] = "&Oacute;"
	whatImean[195][148] = "O"
	whatImeanH[195][148] = "&Ocirc;"
	whatImean[195][149] = "O"
	whatImeanH[195][149] = "&Otilde;"
	whatImean[195][150] = "O"
	whatImeanH[195][150] = "&Ouml;"
	whatImean[195][152] = "O"
	whatImeanH[195][152] = "&Oslash;"
	whatImean[195][153] = "U"
	whatImeanH[195][153] = "&Ugrave;"
	whatImean[195][154] = "U"
	whatImeanH[195][154] = "&Uacute;"
	whatImean[195][155] = "U"
	whatImeanH[195][155] = "&Ucirc;"
	whatImean[195][156] = "U"
	whatImeanH[195][156] = "&Uuml;"
	whatImean[195][157] = "Y"
	whatImeanH[195][157] = "&Yacute;"
	whatImean[195][158] = "Th"
	whatImeanH[195][158] = "&THORN;"
	whatImean[195][159] = "sz"
	whatImeanH[195][159] = "&szlig;"
	whatImean[195][160] = "a"
	whatImeanH[195][160] = "&agrace;"
	whatImean[195][161] = "a"
	whatImeanH[195][161] = "&aacute;"
	whatImean[195][162] = "a"
	whatImeanH[195][162] = "&acirc;"
	whatImean[195][163] = "a"
	whatImeanH[195][163] = "&atilde;"
	whatImean[195][164] = "a"
	whatImeanH[195][164] = "&auml;"
	whatImean[195][165] = "a"
	whatImeanH[195][165] = "&aring;"
	whatImean[195][166] = "ae"
	whatImeanH[195][166] = "&aelig;"
	whatImean[195][167] = "c"
	whatImeanH[195][167] = "&ccedil;"
	whatImean[195][168] = "e"
	whatImeanH[195][168] = "&egrave;"
	whatImean[195][169] = "e"
	whatImeanH[195][169] = "&eacute;"
	whatImean[195][170] = "e"
	whatImeanH[195][170] = "&ecirc;"
	whatImean[195][171] = "e"
	whatImeanH[195][171] = "&euml;"
	whatImean[195][172] = "i"
	whatImeanH[195][172] = "&igrave;"
	whatImean[195][173] = "i"
	whatImeanH[195][173] = "&iacute;"
	whatImean[195][174] = "i"
	whatImeanH[195][174] = "&icirc;"
	whatImean[195][175] = "i"
	whatImeanH[195][175] = "&iuml;"
	whatImean[195][176] = "d"
	whatImeanH[195][176] = "&eth;"
	whatImean[195][177] = "n"
	whatImeanH[195][177] = "&ntilde;"
	whatImean[195][178] = "o"
	whatImeanH[195][178] = "&ograve;"
	whatImean[195][179] = "o"
	whatImeanH[195][179] = "&oacute;"
	whatImean[195][180] = "o"
	whatImeanH[195][180] = "&ocirc;"
	whatImean[195][181] = "o"
	whatImeanH[195][181] = "&otilde;"
	whatImean[195][182] = "o"
	whatImeanH[195][182] = "&ouml;"
	whatImean[195][184] = "o"
	whatImeanH[195][184] = "&oslash;"
	whatImean[195][185] = "u"
	whatImeanH[195][185] = "&ugrave;"
	whatImean[195][186] = "u"
	whatImeanH[195][186] = "&uacute;"
	whatImean[195][187] = "u"
	whatImeanH[195][187] = "&ucirc;"
	whatImean[195][188] = "u"
	whatImeanH[195][188] = "&uuml;"
	whatImean[195][189] = "y"
	whatImeanH[195][189] = "&yacute;"
	whatImean[195][190] = "th"
	whatImeanH[195][190] = "&thorn;"
	whatImean[195][191] = "y"
	whatImeanH[195][191] = "&yuml;"
	whatImean[196] = "" * 255
	whatImeanH[196] = "" * 255
	whatImean[196][188] = "l"
	whatImeanH[196][188] = "&#316;" # l-cedilla
	whatImean[197] = "" * 255
	whatImeanH[197] = "" * 255
	whatImean[197][160] = "S"
	whatImeanH[197][160] = "&Scaron;"
	whatImean[197][161] = "s"
	whatImeanH[197][161] = "&scaron;"
	whatImean[197][189] = "Z"
	whatImeanH[197][189] = "&#381;" # Z-caron
	whatImean[197][190] = "z"
	whatImeanH[197][190] = "&#382;" # z-caron
	whatImean[208] = "" * 255
	whatImeanH[208] = "" * 255
	whatImean[208][149] = "E"
	whatImeanH[208][149] = "E" # Cyrillic E (why???)
	whatImean[226] = "" * 255
	whatImeanH[226] = "" * 255
	whatImean[226][128] = "" * 255
	whatImean[226][128][147] = "-" # en-dash
	whatImeanH[226][128][147] = "-" # en-dash
	whatImean[226][128][153] = "'" # right-side quote
	whatImeanH[226][128][153] = "'" # right-side quote
	whatImean[226][132] = "" * 255
	whatImean[226][132][162] = "" # trademark
	whatImeanH[226][132][162] = "" # trademark

	out_news = ""
	in_news = list(the_text)

	for index, value in enumerate(in_news):
		if value == 0:
			pass
		if value >= 32 and value < 128:
			out_news = out_news + chr(value)
		elif value >= 128 and value < 224:
			if whatImean[value][index+1] is not None:
				if out == "h":
					out_news = out_news + whatImeanH[value][index+1]
				else:
					out_news = out_news + whatImean[value][index+1]
				in_news[index+1] = 0
			else:
				print("==== Code page "+value+" ====")
				for y in range(index-5, index+5):
					if (in_news[y] < 128):
						print(str(in_news[y])+" => "+chr(in_news[y]))
					else:
						print(str(in_news[y])+" => ??")
				print("====")

		elif value >= 224:
			if whatImean[value][index+1][index+2] is not None:
				if out == "h":
					out_news = out_news + whatImeanH[value][index+1][index+2]
				else:
					out_news = out_news + whatImean[value][index+1][index+2]
				in_news[index+1] = 0
				in_news[index+2] = 0
			else:
				print("==== End of code page 226 ====")
				for y in range(index-5, index+5):
					if (in_news[y] < 128):
						print(str(in_news[y])+" => "+chr(in_news[y]))
					else:
						print(str(in_news[y])+" => ??")
				print("====")

	return out_news

def defineLeague(token, id, pl):
	max_age = 0 #time in hours that a ladder file needs to be before it is overwritten
	ladder_file = "./news/ladder/"+token+".lad"
	file_exists = False

	if os.path.isfile(ladder_file):
		file_exists = True
		debug("Ladder file exists already.")
		st=os.stat(ladder_file)
		age=(time.time()-st.st_mtime)

	if (file_exists == False) or (file_exists and age >= (60*60*max_age)): # if the file exists, is it older than eight hours?
		debug("Ladder file doesn't exist or is more than 8 hours old")
		if int(id) > 0:
			debug("Comp ID isn't 0, so we use that in ladder download")
			this_ladder = get_data("http://fotmobenetpulse.s3-external-3.amazonaws.com/tables.ext."+id+".fot")
			if b"Access Denied" in this_ladder:
				debug("...but we got an Access Denied error. So we're using the lpl code.")
				this_ladder = get_data("http://fotmobenetpulse.s3-external-3.amazonaws.com/tables.ext."+pl+".fot")
		else:
			debug("lid not set, so downloading ladder data using lpl.")
			this_ladder = get_data("http://fotmobenetpulse.s3-external-3.amazonaws.com/tables.ext."+pl+".fot")

		out_table = {}
		this_ladder = washText(this_ladder, token)
		this_ladder = re.sub("&amp;", "", this_ladder)
		this_ladder = re.sub(">", ">QQ", this_ladder)

		the_ladder = this_ladder.split("QQ")
		
		for tl in the_ladder:
			if "<table " in tl:
				gnm = "one"
				out_table[gnm] = {}
				out_table[gnm]["fate"] = re.findall("l_(.+?)=\"(.+?)\"", tl)
				t_name = pluck(" name=\"(.+?)\"", tl)
				out_table[gnm]["name"] = cleanWords(t_name).lower()
				out_table[gnm]["table"] = []
			elif "<subt " in tl:
				gnm = pluck(" name=\"(.+?)\"", tl)
				out_table[gnm] = {}
				out_table[gnm]["fate"] = re.findall("l_(.+?)=\"(.+?)\"", tl)
				t_name = pluck(" name=\"(.+?)\"", tl)
				out_table[gnm]["name"] = cleanWords(t_name)
				out_table[gnm]["table"] = []
			elif "<t " in tl:
				#<t name="Reus" id="96927" p="0" w="5" d="6" l="30" g="16" c="47" hp="8" hw="1" hd="5" hl="15" hg="8" hc="25" change="" deduction="-21" />
				tnm = cleanWords(pluck(" name=\"(.+?)\"", tl)).lower()
				tpt = pluck(" p=\"(.+?)\"", tl)
				two = pluck(" w=\"(.+?)\"", tl)
				tdr = pluck(" d=\"(.+?)\"", tl)
				tlo = pluck(" l=\"(.+?)\"", tl)
				tgf = pluck(" g=\"(.+?)\"", tl)
				tga = pluck(" c=\"(.+?)\"", tl)
				if ' deduction' in tl: tde = pluck(" deduction=\"(.+?)\"", tl)
				else : tde = ""
				table_line = "|".join([tnm,two,tdr,tlo,tgf,tga,tpt,tde])
				out_table[gnm]["table"].append(table_line)

		for tl in out_table:
			for f in out_table[tl]["fate"]:
				the_pos = f[1]
				if f[0] == 'champ_playoff':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|FINALS"
				elif f[0] == 'promotion_playoff':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|PRPLAYOFF"
				elif f[0] == 'promotion':
					count = 0
					while count < int(the_pos):
						out_table[tl]["table"][count] = out_table[tl]["table"][count]+"|PROMOTED"
						count += 1
				elif f[0] == 'relegation':
					count = -1
					while count >= int(the_pos)*-1:
						out_table[tl]["table"][count] = out_table[tl]["table"][count]+"|RELEGATED"
						count -= 1
				elif f[0] == 'relegation_playoff':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|RLPLAYOFF"
				elif f[0] == 'copa_libertadores':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|COPALIB"
				elif f[0] == 'copa_libertadores_qual':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|COPALIBQ"
				elif f[0] == 'copa_sudamericana':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|COPASUD"
				elif f[0] == 'qual_next_poss':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|NEXTPOS"
				elif f[0] == 'cl':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|UCL"
				elif f[0] == 'cl_qual':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|UCLQ"
				elif f[0] == 'uefa':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|EL"
				elif f[0] == 'uefa_qual':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|ELQ"
				elif f[0] == 'qual_next':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|QUAL"
				else:
					out_table[tl]["table"].append(f[0]+"~"+the_pos)
			debug("Fates calculated.")

		otab = open("./news/ladder/"+token+".lad", "w")
		for group in out_table:
			otab.write("\ngroup|"+out_table[group]["name"]+"\n")
			tab = "\n".join(out_table[group]["table"])
			otab.write(tab)
		otab.close

def defineMatch(the_match):
	"""Group match. <match id="2977566" hTeam="Brazil" aTeam="Bolivia" hScore="3" aScore="0" hId="8256" aId="5797" stage="1" time="15.06.2019 02:30"  Status="F" ijt="2,4" med="1" sId="6" gs="15.06.2019 02:30:32" shs="15.06.2019 03:32:35" extid="ls_81140310" />
	Playoff match, first leg <match id="3052071" hTeam="Malaga" aTeam="Deportivo La Coruna" hScore="0" aScore="0" hId="9864" aId="9783" stage="1/2" time="15.06.2019 21:00" Status="N" agg="2-4" sId="1" extid="ls_0" />
	2nd Leg then penalties! <match id="3046156" hTeam="Universidad de Concepcion" aTeam="Deportes Valdivia" hScore="4" aScore="6" hId="4054" aId="770322" stage="1/16" time="13.06.2019 01:00" Status="F" agg="4-6" aggh="lost" agga="won" pah="3" paa="5" sId="13" gs="13.06.2019 00:58:47" shs="13.06.2019 02:02:02" extid="ls_81129586" />
	Simple league match <match id="3035933" hTeam="Madura United" aTeam="PSS Sleman" hScore="0" aScore="0" hId="165199" aId="585847" stage="4" time="14.06.2019 10:30" Status="F" sId="5" extid="ls_0" />"""
	mid = pluck(" id=\"(.+?)\"", the_match)
	mht = cleanWords(pluck(" hTeam=\"(.+?)\"", the_match)).lower()
	mat = cleanWords(pluck(" aTeam=\"(.+?)\"", the_match)).lower()
	mhs = pluck(" hscore=\"(.+?)\"", the_match)
	mas = pluck(" ascore=\"(.+?)\"", the_match)
	mrd = pluck(" stage=\"(.+?)\"", the_match)
	mts = pluck(" time=\"(.+?)\"", the_match)
	ms1 = pluck(" status=\"(.+?)\"", the_match)
	ms2 = pluck(" sid=\"(.+?)\"", the_match)
	mag = pluck(" agg=\"(.+?)\"", the_match)
	mah = pluck(" aggh=\"(.+?)\"", the_match)
	mph = pluck(" pah=\"(.+?)\"", the_match)
	mpa = pluck(" paa=\"(.+?)\"", the_match)

	status = ms1+"-"+ms2

	mdetails = washText(get_data("http://fotmobenetpulse.s3-external-3.amazonaws.com/matchfacts."+mid+".fot"), mid+":"+mht+":"+mat, "h")
	mdetails = re.sub("&amp;", "", mdetails)
	
	if "Access Denied" in mdetails:
		debug("Access Denied for mid "+mid)
	#md = open("news/match/"+mid+"_"+mht+"_"+mhs+"-"+mas+"_"+mat+"-"+status+".mch", "w")
	#md.write(mdetails)
	#md.close

	d_venue = pluck("<vn>(.+?)</vn>", mdetails)

	d_venue2 = pluck("<venue>(.+?)</venue>", mdetails)
	if d_venue != "":
		dv2_venue = pluck("\"name\":\"(.+?)\"", d_venue2)
		dv2_loc = pluck("\"city\":\"(.+?)\"", d_venue2)
		if dv2_venue != "" and dv2_loc != "":
			d_venue = dv2_venue+", "+dv2_loc

	d_coach = pluck("<COACH>(.+?)</COACH>", mdetails)
	if d_coach != "":
		coach_details = d_coach.split(":")
		d_coach = coach_details[0]+":"+coach_details[1]+"~"+coach_details[2]+":"+coach_details[3]
		debug("Coaches: "+coach_details[0]+":"+coach_details[1]+" "+coach_details[2]+":"+coach_details[3])

	dmd = pluck("<gd>(.+?)</gd>", mdetails)
	if dmd != "":
		event_list = ""
		dmd = re.sub("/#$/", "", dmd)
		match_details = dmd.split("#")
		debug(str(len(match_details))+" events.")
		for event in match_details:
			if event == '': 
				break
			e = event.split(":")
			time = e[1]
			player = e[2]
			code = e[4]+"~"+e[5]
			if e[0] == "1":
				event = "homegoal"
			elif e[0] == "2":
				event = "awaygoal"
			elif e[0] == "3":
				event = "homered"
			elif e[0] == "4":
				event = "awayred"
			elif e[0] == "5":
				event = "homeyellow"
			elif e[0] == "6":
				event = "awayyellow"
			elif e[0] == "9":
				event = "homenogoal"
			elif e[0] == "10":
				event = "awaynogoal"
			elif e[0] == "34":
				event = "homeassist"
			elif e[0] == "35":
				event = "awayassist"
			else:
				event = e[0]
			event_list += "~".join([time,player,event,code])+"#"
		dmd = re.sub("/#$/", "", event_list)

	d_subs = pluck("<SUBST>(.+?)</SUBST>", mdetails)
	if d_subs != "":
		sub_list = ""
		d_subs = re.sub("/^#/", "", d_subs)
		subs = d_subs.split("#")
		for this_sub in subs:
			if len(this_sub) > 1:
				s = this_sub.split(":")
				if s[0] == "0":
					s[0] = "a"
				elif s[0] == "1":
					s[0] = "h"
				sub_list += s[1]+"~"+s[0]+"~"+s[3]+"~"+s[5]+"#"
		d_subs = re.sub("/#$/", "", sub_list)

	d_facts = pluck("<ff>(.+?)</ff>", mdetails)
	if d_facts != "":
		d_fu = re.findall("\"Fact\":\"(.+?)\"", d_facts)
		d_facts = "~".join(d_fu), "h"

	mt = mid+"|"+mht+"|"+mhs+"|"+mas+"|"+mat+"|"+mrd+"|"+mts+"|"+status+"|"+mag+"|"+mah+"|"+mph+"|"+mpa+"|"+d_coach+"|"+d_venue+"|"+dmd+"|"+d_subs+"|"
	debug(mt)
	return mt

def main():
	main_url = 'http://fotmobenetpulse.s3-external-3.amazonaws.com/live2.fot'
	original_news = './news/world.orig'
	news_file = './news/world.txt'
	comps_file = './config/comps.csv'
	the_output = []

	ladders = []
	lad_list = open(comps_file, "r")
	debug("Read in comps file.")
	for ldr in lad_list:
		if re.match("^N", ldr):
			n_details = ldr.split(",")
			curr_nat = n_details[1]
		elif re.match("^L", ldr):
			l_details = ldr.split(",")
			curr_lg = l_details[1]
			ladders.append(curr_nat+curr_lg)
	lad_list.close 
	debug("List of ladder bearing competitions completed.")

	""" Now the work begins, get the main data file and parse it using BS4. """

	debug("Getting main data.")
	asc_news = get_data(main_url)
	o_news = washText(asc_news, "main", "n")

	output = open(original_news, "w+")
	output.write(o_news)
	output.close

	the_news = o_news.split(">")
	for line in the_news:
		if "<league " in line:
			"""<league id="855008" name="World Cup Grp. E" sl="false" lr="10000" ir="0" ccode="INT" isGrp="true" plName="World Cup 2019 (Women)" grpName="E" pl="76">"""
			lcc = pluck(' ccode=\"(.+?)\"', line)
			lid = pluck(' id=\"(.+?)\"', line)
			lnm = pluck(' name=\"(.+?)\"', line)
			if re.search(' isgrp=', line, re.IGNORECASE): lgr = pluck(' isgrp=\"(.+?)\"', line)
			else:	lgr = ""
			if re.search(' pl=', line, re.IGNORECASE): lpl = pluck(' pl=\"(.+?)\"', line)
			else:	lpl = ""
			if re.search(' plname=', line, re.IGNORECASE): ltn = pluck(' plName=\"(.+?)\"', line)
			else:	ltn = ""
			if re.search(' grpname=', line, re.IGNORECASE): lgn = pluck(' grpname=\"(.+?)\"', line)
			else:	lgn = ""

			lnm = cleanWords(lnm).lower()
			ltn = cleanWords(ltn).lower()

			league_line = lcc+"|"+lnm+"|"+lid+"|"+lgr+"|"+lpl+"|"+ltn+"|"+lgn
			the_output.append(league_line)

			if lcc+lnm in ladders:
				defineLeague(lcc+lnm, lid, lpl)
		elif "<match " in line:
			this_match = defineMatch(line)
			the_output.append(this_match)

	todays_news = open(news_file, "w")
	todays_news.write("\n".join(the_output))
	todays_news.close

"""
Here be the place
"""

if os.path.isfile('./config/wfh.txt'): 
	DEBUG = 1
else:
	DEBUG = 0

if __name__ == "__main__":
	main()
