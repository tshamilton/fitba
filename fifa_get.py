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
	txt = re.sub(r'[\s|\'|\.|\-|\/|\°|\(|\)]', "", text)
	return txt

def washText(the_text, context, out="n"):
	out_news = ""
	the_text = re.sub(b'&amp;', b'', the_text)
	in_news = list(the_text)

	for index, value in enumerate(in_news):
		if value == 0:
			pass
		if (value >= 32 and value < 128):
			out_news = out_news + chr(value)
		elif (value > 128):
			if value == 194:
				if (in_news[index+1] < 160):
					in_news[index+1] = 0
					pass
				elif (in_news[index+1] == 160):
					if out == "h":	out_news = out_news + "&nbsp;"
					else:			out_news = out_news + " "
					in_news[index+1] = 0
				elif (in_news[index+1] == 173):
					if out == "h":	out_news = out_news + "-"
					else:			out_news = out_news + "-"
					in_news[index+1] = 0
				elif (in_news[index+1] == 179):
					if out == "h":	out_news = out_news + "3"
					else:			out_news = out_news + "3"
					in_news[index+1] = 0
				elif (in_news[index+1] == 180):
					if out == "h":	out_news = out_news + "'"
					else:			out_news = out_news + "'"
					in_news[index+1] = 0
				else:
					#print("==== End of code page 194 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			elif value == 195:
				if (in_news[index+1] == 128):
					if out == "h":	out_news = out_news + "&Agrave;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 129):
					if out == "h":	out_news = out_news + "&Aacute;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 130):
					if out == "h":	out_news = out_news + "&Acirc;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 131):
					if out == "h":	out_news = out_news + "&Atilde;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 132):
					if out == "h":	out_news = out_news + "&Auml;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 133):
					if out == "h":	out_news = out_news + "&Aring;"
					else:			out_news = out_news + "A"
					in_news[index+1] = 0
				elif (in_news[index+1] == 134):
					if out == "h":	out_news = out_news + "&AElig;"
					else:			out_news = out_news + "Ae"
					in_news[index+1] = 0
				elif (in_news[index+1] == 135):
					if out == "h":	out_news = out_news + "&Ccedil;"
					else:			out_news = out_news + "C"
					in_news[index+1] = 0
				elif (in_news[index+1] == 136):
					if out == "h":	out_news = out_news + "&Egrave;"
					else:			out_news = out_news + "E"
					in_news[index+1] = 0
				elif (in_news[index+1] == 137):
					if out == "h":	out_news = out_news + "&Eacute;"
					else:			out_news = out_news + "E"
					in_news[index+1] = 0
				elif (in_news[index+1] == 138):
					if out == "h":	out_news = out_news + "&Ecirc;"
					else:			out_news = out_news + "E"
					in_news[index+1] = 0
				elif (in_news[index+1] == 139):
					if out == "h":	out_news = out_news + "&Euml;"
					else:			out_news = out_news + "E"
					in_news[index+1] = 0
				elif (in_news[index+1] == 140):
					if out == "h":	out_news = out_news + "&Igrave;"
					else:			out_news = out_news + "I"
					in_news[index+1] = 0
				elif (in_news[index+1] == 141):
					if out == "h":	out_news = out_news + "&Iacute;"
					else:			out_news = out_news + "I"
					in_news[index+1] = 0
				elif (in_news[index+1] == 142):
					if out == "h":	out_news = out_news + "&Icirc;"
					else:			out_news = out_news + "I"
					in_news[index+1] = 0
				elif (in_news[index+1] == 143):
					if out == "h":	out_news = out_news + "&Iuml;"
					else:			out_news = out_news + "I"
					in_news[index+1] = 0
				elif (in_news[index+1] == 144):
					if out == "h":	out_news = out_news + "&ETH;"
					else:			out_news = out_news + "D"
					in_news[index+1] = 0
				elif (in_news[index+1] == 145):
					if out == "h":	out_news = out_news + "&Ntilde;"
					else:			out_news = out_news + "N"
					in_news[index+1] = 0
				elif (in_news[index+1] == 146):
					if out == "h":	out_news = out_news + "&Ograve;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 147):
					if out == "h":	out_news = out_news + "&Oacute;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 148):
					if out == "h":	out_news = out_news + "&Ocirc;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 149):
					if out == "h":	out_news = out_news + "&Ocirc;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 150):
					if out == "h":	out_news = out_news + "&Ouml;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 152):
					if out == "h":	out_news = out_news + "&Oslash;"
					else:			out_news = out_news + "O"
					in_news[index+1] = 0
				elif (in_news[index+1] == 153):
					if out == "h":	out_news = out_news + "&Ugrave;"
					else:			out_news = out_news + "U"
					in_news[index+1] = 0
				elif (in_news[index+1] == 154):
					if out == "h":	out_news = out_news + "&Uacute;"
					else:			out_news = out_news + "U"
					in_news[index+1] = 0
				elif (in_news[index+1] == 155):
					if out == "h":	out_news = out_news + "&Ucirc;"
					else:			out_news = out_news + "U"
					in_news[index+1] = 0
				elif (in_news[index+1] == 156):
					if out == "h":	out_news = out_news + "&Uuml;"
					else:			out_news = out_news + "U"
					in_news[index+1] = 0
				elif (in_news[index+1] == 157):
					if out == "h":	out_news = out_news + "&Yacute;"
					else:			out_news = out_news + "Y"
					in_news[index+1] = 0
				elif (in_news[index+1] == 158):
					if out == "h":	out_news = out_news + "&THORN;"
					else:			out_news = out_news + "Th"
					in_news[index+1] = 0
				elif (in_news[index+1] == 159):
					if out == "h":	out_news = out_news + "&szlig;"
					else:			out_news = out_news + "sz"
					in_news[index+1] = 0
				elif (in_news[index+1] == 160):
					if out == "h":	out_news = out_news + "&agrave;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 161):
					if out == "h":	out_news = out_news + "&aacute;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 162):
					if out == "h":	out_news = out_news + "&acirc;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 163):
					if out == "h":	out_news = out_news + "&atilde;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 164):
					if out == "h":	out_news = out_news + "&auml;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 165):
					if out == "h":	out_news = out_news + "&aring;"
					else:			out_news = out_news + "a"
					in_news[index+1] = 0
				elif (in_news[index+1] == 166):
					if out == "h":	out_news = out_news + "&aelig;"
					else:			out_news = out_news + "ae"
					in_news[index+1] = 0
				elif (in_news[index+1] == 167):
					if out == "h":	out_news = out_news + "&ccedil;"
					else:			out_news = out_news + "c"
					in_news[index+1] = 0
				elif (in_news[index+1] == 168):
					if out == "h":	out_news = out_news + "&egrave;"
					else:			out_news = out_news + "e"
					in_news[index+1] = 0
				elif (in_news[index+1] == 169):
					if out == "h":	out_news = out_news + "&eacute;"
					else:			out_news = out_news + "e"
					in_news[index+1] = 0
				elif (in_news[index+1] == 170):
					if out == "h":	out_news = out_news + "&ecirc;"
					else:			out_news = out_news + "e"
					in_news[index+1] = 0
				elif (in_news[index+1] == 171):
					if out == "h":	out_news = out_news + "&euml;"
					else:			out_news = out_news + "e"
					in_news[index+1] = 0
				elif (in_news[index+1] == 172):
					if out == "h":	out_news = out_news + "&igrave;"
					else:			out_news = out_news + "i"
					in_news[index+1] = 0
				elif (in_news[index+1] == 173):
					if out == "h":	out_news = out_news + "&iacute;"
					else:			out_news = out_news + "i"
					in_news[index+1] = 0
				elif (in_news[index+1] == 174):
					if out == "h":	out_news = out_news + "&icirc;"
					else:			out_news = out_news + "i"
					in_news[index+1] = 0
				elif (in_news[index+1] == 175):
					if out == "h":	out_news = out_news + "&iuml;"
					else:			out_news = out_news + "i"
					in_news[index+1] = 0
				elif (in_news[index+1] == 176):
					if out == "h":	out_news = out_news + "&eth;"
					else:			out_news = out_news + "d"
					in_news[index+1] = 0
				elif (in_news[index+1] == 177):
					if out == "h":	out_news = out_news + "&ntilde;"
					else:			out_news = out_news + "n"
					in_news[index+1] = 0
				elif (in_news[index+1] == 178):
					if out == "h":	out_news = out_news + "&ograve;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 179):
					if out == "h":	out_news = out_news + "&oacute;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 180):
					if out == "h":	out_news = out_news + "&ocirc;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 181):
					if out == "h":	out_news = out_news + "&otilde;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 182):
					if out == "h":	out_news = out_news + "&ouml;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 184):
					if out == "h":	out_news = out_news + "&oslash;"
					else:			out_news = out_news + "o"
					in_news[index+1] = 0
				elif (in_news[index+1] == 185):
					if out == "h":	out_news = out_news + "&ugrave;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				elif (in_news[index+1] == 186):
					if out == "h":	out_news = out_news + "&uacute;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				elif (in_news[index+1] == 187):
					if out == "h":	out_news = out_news + "&ucirc;"
					else:			out_news = out_news + "i"
					in_news[index+1] = 0
				elif (in_news[index+1] == 188):
					if out == "h":	out_news = out_news + "&uuml;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				elif (in_news[index+1] == 189):
					if out == "h":	out_news = out_news + "&yacute;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				elif (in_news[index+1] == 190):
					if out == "h":	out_news = out_news + "&thorn;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				elif (in_news[index+1] == 191):
					if out == "h":	out_news = out_news + "&yuml;"
					else:			out_news = out_news + "u"
					in_news[index+1] = 0
				else:
					#print("==== End of code page 195 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			elif value == 196:
				if in_news[index+1] == 135:
					if out == "h":	out_news = out_news + "&#263;"
					else:			out_news = out_news + "c"
					in_news[index+1] = 0
				elif in_news[index+1] == 141:
					if out == "h":	out_news = out_news + "&#265;"
					else:			out_news = out_news + "c"
					in_news[index+1] = 0
				elif in_news[index+1] == 188:
					if out == "h":	out_news = out_news + "l"
					else:			out_news = out_news + "l"
					in_news[index+1] = 0
				else:
					#print("==== End of code page 196 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			elif value == 197:
				if in_news[index+1] == 160:
					if out == "h": out_news = out_news + "&Scaron;"
					else:			out_news = out_news + "S"
					in_news[index+1] = 0
				elif in_news[index+1] == 161:
					if out == "h": out_news = out_news + "&scaron;"
					else:			out_news = out_news + "s"
					in_news[index+1] = 0
				elif in_news[index+1] == 189:
					if out == "h": out_news = out_news + "&#381;"
					else:			out_news = out_news + "Z"
					in_news[index+1] = 0
				elif in_news[index+1] == 190:
					if out == "h": out_news = out_news + "&#382;"
					else:			out_news = out_news + "z"
					in_news[index+1] = 0
				else:
					#print("==== End of code page 197 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			elif value == 208:
				if in_news[index+1] == 149:
					if out == "h":	out_news = out_news + "E"
					else:			out_news = out_news + "E"
					in_news[index+1] = 0
				else:
					#print("==== End of code page 208 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			elif value == 226:
				if in_news[index+1] == 128:
					if in_news[index+2] == 147:
						if out == "h":	out_news = out_news + "-"
						else:			out_news = out_news + "-"
					elif in_news[index+2] == 153:
						if out == "h":	out_news = out_news + "'"
						else:			out_news = out_news + "'"
					in_news[index+1] = 0
					in_news[index+2] = 0
				elif in_news[index+1] == 132:
					if in_news[index+2] == 162:
						in_news[index+1] = 0
						in_news[index+2] = 0
						pass
				else:
					#print("==== End of code page 226 ====")
					for y in range(index-5, index+5):
						if (in_news[y] < 128):
							pass #print(str(in_news[y])+" => "+chr(in_news[y]))
						else:
							pass #print(str(in_news[y])+" => ??")
					#print("====")
			else:
				#print("== Code page '"+str(index)+"' unknown. Context: "+context+" ==")
				for y in range(index-5, index+5):
					if (in_news[y] < 128):
						pass #print(str(in_news[y])+" -> "+chr(in_news[y]))
					else:
						pass #print(str(in_news[y])+" -> ??")
				#print("====")
	return out_news

def defineLeague(token, id, pl):
	max_age = 4 #time in hours that a ladder file needs to be before it is overwritten
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
						try:
							out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|RLPLAYOFF"
						except IndexError:
							next
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
				elif f[0] == 'uefa_qual_playoff':
					pos = the_pos.split(",")
					for p in pos:
						out_table[tl]["table"][int(p)-1] = out_table[tl]["table"][int(p)-1]+"|ELQP"
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
		d_facts = "~".join(d_fu)

	mt = mid+"|"+mht+"|"+mhs+"|"+mas+"|"+mat+"|"+mrd+"|"+mts+"|"+status+"|"+mag+"|"+mah+"|"+mph+"|"+mpa+"|"+d_coach+"|"+d_venue+"|"+dmd+"|"+d_subs+"|"+d_facts+"|"
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
			if "~" in l_details[1]:
				l_names = l_details[1].split("~")
				for x in l_names:
					ladders.append(curr_nat+x)
			else:
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
