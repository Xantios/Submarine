<?php
/*
    ============================================
    Xantios Krugor  - Submarine
    ===============================
    
    Usage of this file:
        The most important function here would be parsing names ( Yeah really)
        Just to convert filenames to an array, so we can use the bierdopje API
        
    Date of creation: 25 June 2012
    Date of Update: Not yet used
    
    Copyright (c) 2012, Xantios Krugor
    All rights reserved.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:
    1. Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
    2. Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.
    3. All advertising materials mentioning features or use of this software
   must display the following acknowledgement:
   This product includes software developed by the Xantios Krugor.
    4. Neither the name of Xantios Krugor nor the
   names of its contributors may be used to endorse or promote products
   derived from this software without specific prior written permission.

    THIS SOFTWARE IS PROVIDED BY XANTIOS KRUGOR ''AS IS'' AND ANY
    EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL XANTIOS KRUGOR BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/


/* Start of code, dont touch anything here if you are NOT a developer and dont want stuff to break! */


//===========================================================
// Class: StringFuncs
// Usage: Default PHP Behaviour should be sufficient
// Dependencies: none
//===========================================================
// Some example strings we'll need to parse.

// Random names
// True.Blood.S02E06.REPACK.720p.BluRay.X264-REWARD
// The.Big.Bang.Theory.S04E23.HDTV.XviD-FQM.ext
// The.Big.Bang.Theory.S04E22.REPACK.720p.HDTV.x264-CTU.ext
// The.Big.Bang.Theory.S04E24.WEB-DL.720p.DD5.1.H.ext
// TV Episode - S01E01.ext

class StringFuncs
{
    //============================
    // Function: __construct
    // Usage: initializer
    // return: void
    //============================
    public function __construct()
    {
        
    }
    
    //=====================================
    // Function: SXXEXX_Name
    // Usage: <String(EpisodeName)>
    // return: string (Empty on error)
    //======================================
    public function SXXEXX_Name($sInput)
    {
        // Get the first part of the name
        $aSerieName = explode("S",$sInput,2);
        $sName = $aSerieName[0];
        // do some replacemants.
        $sName = str_replace("-"," ",$sName);
        $sName = str_replace("_"," ",$sName);
        $sName = str_replace(","," ",$sName);
        $sName = str_replace("."," ",$sName);
        print $sName;
        return $sName;
    }
    
    //=====================================
    // Function: SXXEXX_Season
    // Usage: <String(EpisodeName)>
    // return: int >0 or -1 on error.
    //======================================
    public function SXXEXX_Season($sInput)
    {
        /////////////////////////////////////////////////////////////////////////////////
        // Cut method one: SXXEXX////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////
        // The most common way I receive my series are in a name format                //
        // using something like SerieName.S01E01.720p.BluRay.X264-RELEASEGROUP         //   
        // So lets try to parse that name to a array! :-D                              //
        /////////////////////////////////////////////////////////////////////////////////
        $aSerieName = explode("S",$sInput,2);
        
        // Check if that went well
        if(count($aSerieName)-1 != 2)
        {
            // Get the first 2 digit's for example S02 becomes 02
            $iSeason = substr($aSerieName[1],0,2);
            
            // Lets check and fix the E bug when
            // S1E1 method is used.
            if(substr($iSeason,1,1)=="E")
            { $iSeason=substr($iSeason,0,strlen($iSeason)-1); } // chop of the last char ( The E ) 
            
            // We can't check for pre-nulled names by checking if <10 because it should be a int,
            // but we cant typecast in PHP :-(
            if(substr($iSeason,0,1)=="0")
            {
                $iSeason=substr($iSeason,1,strlen($iSeason));
            }
            
            // Lets return as a int.
            return $iSeason;                        
        }
        else return -1;
    }
    
    //=====================================
    // Function: SXXEXX_Episode
    // Usage: <String(EpisodeName)>
    // return: int >0 or -1 on error.
    //======================================
    public function SXXEXX_Episode($sInput)
    {
        // Lets split! 
        $aSerieName = explode("E",$sInput,2);
        
        // Check if that went well
        if(count($aSerieName)-1 != 2)
        {
            // Get the first 2 digit's for example E02 becomes 02
            $iEpisode = substr($aSerieName[1],0,2);
            
            // Lets try if we can assume a int here.
            // so we can rip of the prefixed 0.
            if($iEpisode<10)
            {
                $iEpisode=substr($iEpisode,1,strlen($iEpisode));
            }
            return $iEpisode;
        }
        else return -1;
        
    }
}



?>