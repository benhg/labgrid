import sys
import os 
import MySQLdb


size=1
#sets up variables
jobname = sys.argv[1]
outfile = "%s.out"%jobname
executable_file = sys.argv[2]
filetype = sys.argv[3]
arguments = sys.argv[4]
jobid=sys.argv[5]
size=sys.argv[6]

logger = open("/var/www/html/logs/pylog.txt", "w")
logger.write("Writing log\n")
#creates directory for job to run in
initialpath="/var/lib/condor/dropbox/%s_%s" %(jobname,jobid)


if os.path.isfile("%s/%s_%s/%s"%(initialpath, jobname, jobid, arguments)):
	size=len(arguments)


#writes the meat of the file
writer = open("%s/%s.sub" %(initialpath,jobname) , 'w')
writer.write("should_transfer_files = YES\nwhen_to_transfer_output = ON_EXIT\n")
writer.write("\ninitialdir = %s\n" %(initialpath))
writer.write("executable=%s/%s\n" %(initialpath,executable_file))
writer.write("output = $(initialdir)/%s.out\n" %jobname)
writer.write("error = $(initialdir)/%s.err\n" %jobname)
writer.write("log = $(initialdir)/%s.log\n" %jobname)
writer.write("notification=Always\n")
writer.write("")
if os.path.isfile("%s/%s_%s/%s"%(initialpath, jobname, jobid, arguments)) :
	arguments=open(arguments)
	for line in arguments:
		writer.write("arguments=%s\n" %line)
		writer.write("queue 1\n")
else:
	print(size)
	writer.write("queue %s\n" % size)

writer.close()

#submits job
output=os.popen("condor_submit %s/%s.sub -verbose" %(initialpath,jobname)).read()
#logger.write(output)
logger.write(output.split("\n")[0])
if(output != None and output.split("\n")[0] == "Submitting job(s)"):
    logger.write("Running jobs successful\n")
    condor_id=output.split("\n")[1][8:-1]
    logger.write(condor_id)
    db = MySQLdb.connect("localhost","root","bakersdozen","labgrid" )
    cursor = db.cursor()
    sql="UPDATE jobs SET condor_id = %s WHERE jobs.id =%s"%(condor_id,jobid)
    cursor.execute(sql)
    db.close()   
logger.close()
