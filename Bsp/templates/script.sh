#!/bin/sh
##
##    author:   <ST::TEXT>Name</ST::TEXT>
##    contact:  <ST::TEXT>EMail</ST::TEXT>
##    version:  <ST::TEXT>Version</ST::TEXT>
##    date:     <ST::TEXT>Datum</ST::TEXT>
##    short description: <ST::TEXT>Beschreibung</ST::TEXT>
##
##
##    This file is part of <ST::TEXT>Programmname</ST::TEXT>.
##
##    <ST::TEXT>Programmname</ST::TEXT> is free software: you can redistribute it and/or modify
##    it under the terms of the GNU General Public License as published by
##    the Free Software Foundation, either version 3 of the License, or
##    (at your option) any later version.
##
##    <ST::TEXT>Programmname</ST::TEXT> is distributed in the hope that it will be useful,
##    but WITHOUT ANY WARRANTY; without even the implied warranty of
##    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
##    GNU General Public License for more details.
##
##    You should have received a copy of the GNU General Public License
##    along with <ST::TEXT>Programmname</ST::TEXT>.  If not, see <http://www.gnu.org/licenses/>.
##

# generate filename without directory:
FILENAME=$(basename $0)
CAT=$(which cat)

print_help()
{
##########################################################################
$CAT <<EOF

  $0

  author:      <ST::TEXT>Name</ST::TEXT>, <ST::TEXT>EMail</ST::TEXT>

  version:     <ST::TEXT>Version</ST::TEXT>

  homepage:    <ST::TEXT>Homepage</ST::TEXT>

  copyright:   GPLv3

  usage:       $FILENAME

  description: <ST::TEXT>Beschreibung</ST::TEXT>

               Only root can execute this script.

               Please email me suggestions for improvements and errors!

EOF
##########################################################################
}

## 2do:
##      * 
##      * 



########################################################
########################################################
########################################################
##                                                    ##
##                  PERSONALISATION                   ##
##                                                    ##
########################################################
########################################################
########################################################


# filenames to use for ...




# change to "done", if you changed all options above to _your_ needs!

CONFIGURED_="notdone"


########################################################




# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #

# --- normally you DON'T have to change anything below this line! --- #

# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! #




########################################################
########################################################
########################################################
##                                                    ##
##               hardcoded configuration              ##
##                                                    ##
########################################################
########################################################
########################################################


## generates an ISO timestamp like "2002-01-31T09.43.03"
TIMESTAMP_LONG=`/bin/date +%Y-%M-%dT%H.%M.%S`

## generates a syslog-like timestamp like "2002-01-31"
## lisa qmail:
TIMESTAMP_SHORT=`/bin/date +%Y-%M-%d`

# change to "on" if you want to read the debug-messages (can be much) to trace
# down problems:
export DEBUG="off"


########################################################
########################################################
########################################################
##                                                    ##
##                   F U N C T I O N S                ##
##                                                    ##
########################################################
########################################################
########################################################

## ---------------------------------------------------------

myexit()
{
    doreport debug "function myexit($1) called"

    [ "$1" -lt 1 ] && echo "$FILENAME done."
    [ "$1" -gt 0 ] && echo "$FILENAME aborted with errorcode $1."

#optionally    [ "$1" -gt 0 ] && do_sound_error

    exit $1
}


## ---------------------------------------------------------


## check, if some files needed are not found
testiffound()
{
    doreport debug "function testiffound($1) called"

  if [ -z "$2" ]; then
    doreport debug "The tool \"$1\" is missing because \"$2\" is empty."
    doreport notify "The tool \"$1\" could not be located (missing?)"
    export SOMETHINGMISSING="yes"
  fi
}



## ---------------------------------------------------------

report()
{
## reports the parameter to the stdout

  echo
  echo "==============================================================="
  echo "                                                 $FILENAME"
  echo "$1"
  echo
  echo "==============================================================="
  echo

}



## ---------------------------------------------------------

debugthis()
{
## debugs the script
        #echo $FILENAME: DEBUG: $1
        echo "do nothing" >/dev/null
}



## ---------------------------------------------------------

logthis()
{
## logs some text with a timestamp added
## usage: logthis "mytext"

    ## generates a timestamp of the day
    TIMESTAMP_SHORT=`/bin/date +%Y-%M-%d`

    ## generates a timestamp of the day with time
    TIMESTAMP_LONG=`/bin/date +%Y-%M-%dT%H.%M.%S`

    ## add computername and scriptname like "lisa qmail: "
    LOGTIMESTAMP=$TIMESTAMPSHORT" $HOSTNAME $FILENAME:"


    # probably won't annoy logfiles with this crap?
    #        echo $LOGTIMESTAMP "$1" >> $mylogfile
    #        echo $LOGTIMESTAMP "$1" 
        echo "do nothing" >/dev/null
}



## ---------------------------------------------------------

mailthis()
{
        # usage: $1=To $2=Subject $3=Body

        echo -e "$3" | mail -s "$2" $1
}



## ---------------------------------------------------------


doreport_internal_writestring()
{
## !! for use withing function "doreport" only !!
## prints out all strings on stdout

## 2do: error-msg written with { echo 1>&2 "text" } (stderr)

        echo
        echo "===$1============================================"
        echo "                                                 $FILENAME"


## FIXXME:
## 2DO: loop instead of this quick-hack!!!

        if [ ! -z "$2" ]; then
	    echo "$2"
        fi
        if [ ! -z "$3" ]; then
	    echo "$3"
        fi
        if [ ! -z "$4" ]; then
	    echo "$4"
        fi
        if [ ! -z "$5" ]; then
	    echo "$5"
        fi
        if [ ! -z "$6" ]; then
	    echo "$6"
        fi
        if [ ! -z "$7" ]; then
	    echo "$7"
        fi
        if [ ! -z "$8" ]; then
	    echo "$8"
        fi

        echo
        echo "===============================================================";
        echo

}



## ---------------------------------------------------------


doreport()
{
## reports the parameter to the stdout

## usage: (shortnote|notify|error|debug) string1 [string2] [string3] [...] [string7]

## NEEDS: doreport_internal_writestring


    case "$1" in

    "shortnote") 
	echo "$FILENAME: $2 $3 $4 $5 $6 $7";;

    "notify") 
	doreport_internal_writestring " notification ==" "$2" "$3" "$4" "$5" "$6" "$7";;

    "error") 
        doreport_internal_writestring " ERROR =========" "$2" "$3" "$4" "$5" "$6" "$7";;

    "debug") 
        ## debugs the script
        if [[ "$DEBUG" = "on" ]]; then echo "$TIMESTAMP $FILENAME: DEBUG: $2 $3 $4 $5 $6 $7"; fi;
        echo "do nothing" >/dev/null;;

    "log") 
        ## logs some text with a timestamp added
        ## usage: $2 == "mytext"
      
        TEMP_TIMESTAMPSHORT=`/bin/date +%Y-%M-%d`
        TEMP_TIMESTAMPLONG=`/bin/date +%Y-%M-%dT%H.%M.%S`
        ## add computername and scriptname like "lisa qmail: "
        TEMP_LOGTIMESTAMP=$TEMP_TIMESTAMPSHORT" $HOSTNAME $FILENAME:";

        # probably won't annoy logfiles with this crap?
        #        echo $LOGTIMESTAMP "$2" >> $mylogfile;
        #        echo $LOGTIMESTAMP "$2" ;;
        echo "do nothing" >/dev/null;;

    "mail") 
        # usage: $2=To $3=Subject $4=Body
        echo -e "$4" | mail -s "$3" $2;;

    *)
        doreport_internal_writestring " INTERNAL ERROR " "An error occured, while calling function \"doreport\":" "The parameter that was given ($1) has no target/handle." "Aborting.";
        myexit 1;;

    esac
}




## ---------------------------------------------------------

ask()
{
## asks something (parameter 1-9) the user

  echo
  echo "=== question =================================================="
  echo "                                                 $FILENAME"
  echo "$1"
  [ -n "${2}" ] && echo "$2"
  [ -n "${3}" ] && echo "$3"
  [ -n "${4}" ] && echo "$4"
  [ -n "${5}" ] && echo "$5"
  [ -n "${6}" ] && echo "$6"
  [ -n "${7}" ] && echo "$7"
  [ -n "${8}" ] && echo "$8"
  [ -n "${9}" ] && echo "$9"
  echo
  echo "==============================================================="
  echo

## example: ##  ask "Do you want:" "(y)es or" "(n)o?"
## example: ##  read ANSWER
## example: ##  echo  
## example: ##  case "${ANSWER}" in
## example: ##  
## example: ##  "y"|"Y")
## example: ##    FIXXMEdoit ;;
## example: ##  *)
## example: ##    echo "  OK, maybe you're right." ;
## example: ##    echo "  We don't need these fancy stuff anyway ..." ;
## example: ##    echo ;;
## example: ##
## example: ##  esac

}


## ---------------------------------------------------------

## checks, if the directory given exists and tries to create it, if necessary
## returns: 0 = "exists"/"created" or 1 = "error"
makesure_directory_exists()
{
    doreport debug "function makesure_directory_exists($1) called"

    if [ ! -d "$1" ]; then

      doreport debug "Directory \"$1\" not found! So I try to make it now..."
      mkdir "$1"

      if [ $? -eq 0 ]        # Test exit status
       then
           doreport debug "Directory $1 successfully created!"
	   return 0
       else 
           doreport error "Could NOT create directory $1!" "Most likely: no write-permission OR non existing parent-directory."
	   return 1
       fi

    else
	doreport debug "Directory already found"
	return 0
    fi

## EXAMPLE:
##        makesure_directory_exists "$(dirname $FILENAME)"
##	## check, if given dir is really a directory:
##	if [ -d "$DIRNAME" ]; then
##	  doreport debug "Directory $DIRNAME is checked as a valid directory"
##        else  
##          print_help
##          doreport "error" "Directory $DIRNAME is not an existing directory! (see error-output above for possible reason!)" "aborting."
##          exit 1
##	fi


## unsure, because returns also exits current region!
## if [[ $(makesure_directory_exists "$(dirname $A_file)") ]]; then
##     doreport error "The directory for the tempfile could not be found or generated!"
##     myexit 1
## else
##     doreport debug "Directory exists."
## fi


}


## ---------------------------------------------------------

## checks if file exists; if it does not exist, it will be created
makeSureTheFileExists()
{
    doreport debug "function makeSureTheFileExists($1) called"

    ## wether "touch" exists, is to be checked in preconditions!
    [ -e "$1" ] || `which touch` "$1"
}


## ---------------------------------------------------------

precondition_asserts()
{
## * test for things that are needed
## * check, if caller = root-user
## * check, if everything was configured by the user
## * check, if a parameter is given:

      export SOMETHINGMISSING="no"


      MV=$(which mv)
      testiffound cdrdao $MV
      
      CAT=$(which cat)
      testiffound cat $CAT
      
      GREP=$(which grep)
      testiffound grep $GREP
      
      HEAD=`which head`
      testiffound head $HEAD
      
      AWK=`which awk`
      testiffound awk $AWK
      
      SED=`which sed`
      testiffound sed $SED
      
      FIND=`which find`
      testiffound find $FIND
      
      DATE=`which date`
      testiffound date $DATE
      
      CHOWN=`which chown`
      testiffound chown $CHOWN


    ## check, if any tool was NOT found
    doreport debug "CHECK: any tool missing?"
    if [ "$SOMETHINGMISSING" = "yes" ]; then
      print_help
      doreport error "One or more tool(s), that are needed are missing! (See output above!)" "Please make sure, that you those tools are installed properly and try again." "aborting."
      myexit 2
    fi



      ## check, if caller = root-user
      if [ $(id -u) != "0" ]; then
        print_help
        doreport "error" "You must be the superuser to run this script" >&2
        myexit 1
      fi
      
      
      
      ## check, if everything was configured by the user
      if [ ! "$CONFIGURED_" = "done" ]; then
        print_help
	doreport "error" "Please make sure, that you checked/modified all options" "to meet your requirements!" "(see section "PERSONALISATION" in file $0)"
        myexit 3
      fi
      
      
      
      ## check, if a parameter is given:
      if [ -z "$1" ]; then
        print_help
        doreport "error" "no parameter 1 for ??? found!" "aborting."
        exit 1
      else
        doreport debug "parameter 1 was found."
        SOME_PARAMETER="$1"
      fi


##      ## check, if a parameter is given:
##      if [ -z "$2" ]; then
##        print_help
##        doreport "error" "no parameter 2 for ??? found!" "aborting."
##        exit 1
##      else
##        doreport debug "parameter 2 was found."
##        SOME_PARAMETER="$2"
##      fi


##	## check, if parameter 1 is a directory:
##	if [ -d "$1" ]; then
##	  doreport debug "Parameter 1 is checked as a directory."
##        else  
##          print_help
##          doreport "error" "parameter 1 is not an existing directory!" "aborting."
##          exit 1
##	fi

      

    doreport debug "<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< all checks OK!"
    export PRECONDITIONS_CHECKED="yes"


}



## ---------------------------------------------------------

postcondition_asserts()
{

## * deletes temporary files
## * ...

##  if [ -z "???filename" ]; then
##    ???
##  fi

echo "donothing" >/dev/null

}



########################################################
########################################################
########################################################
##                                                    ##
##                S C R I P T                         ##
##                                                    ##
########################################################
########################################################
########################################################


## test for important stuff:
precondition_asserts "$1" "$2" "$3" "$4" "$4" "$5" "$6" "$7" "$8" "$9"




## parse parameter 1
case "$1" in

    "help"|"--help"|"?"|"/?")
	doreport debug "Parameter help|--help|?|/? detected"
	print_help;
	myexit 0;;

    "kill"|"stop")
	doreport debug "Parameter kill|stop detected"
	blablabla;;

    *)
	doreport debug "Unknown parameter.";
	doreport error "The parameter you typed in ($1) could not be recognised!" "It will ignored and the script halted.";
	print_help;
	myexit 1;;

esac







########################################################


## test for important stuff:
postcondition_asserts

myexit 0


########################################################
##                      E N D                         ##
########################################################
















