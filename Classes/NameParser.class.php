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
// Class: NameParser
// Usage: Default PHP Behaviour should be sufficient
// Dependencies: StringFuncs.class.php
//===========================================================
class NameParser
{
    // init some needed var's.
    public $aName;
    
    //============================
    // Function: __construct
    // Usage: initializer
    // return: void
    //============================
    public function __construct()
    {
        $this->aName = array(); // We'll have to save our elements somewhere ;-)
    }
    
    //============================
    // Function: convert
    // Usage: basicly this is were the conversion gets started
    // return: array
    //============================
    public function convert($sInput)
    {
        // Additional comments:
        // Some example strings we'll need to parse.

        // Random names
        // True.Blood.S02E06.REPACK.720p.BluRay.X264-REWARD
        // The.Big.Bang.Theory.S04E23.HDTV.XviD-FQM.ext
        // The.Big.Bang.Theory.S04E22.REPACK.720p.HDTV.x264-CTU.ext
        // The.Big.Bang.Theory.S04E24.WEB-DL.720p.DD5.1.H.ext
        // TV Episode - S01E01.ext
        
        //Dependency's
        require "StringFuncs.class.php";
        $Methods = new StringFuncs();
        
        // Set some var's
        $sCutMethod = "None"; $iSeason = 0; $iEpisode = 0;
        // Create some flag's
        $bGotSeason = false; $bGotEpisode = false; $bGotSerie = false; $bGotRelease = false;
        $debug = true;
        
        // Lets probe some method's to grep the season part
        $iSeason = $Methods->SXXEXX_Season($sInput);
        if($iSeason != -1)
        {
            $bGotSeason = true;
            $sCutMethod="SXXEXX";
            $this->aName['Season'] = $iSeason;
        }
        else
        {
            $this->aName['Season'] = ""; // The order values can be left default.
        }
        
        // Lets probe some method's to grep the Episode part
        $iEpisode = $Methods->SXXEXX_Episode($sInput);
        if($iEpisode != -1)
        {
            $bGotSeason = true;
            $sCutMethod="SXXEXX";
            $this->aName['Episode'] = $iEpisode;
        }
        else
        {
            $this->aName['Episode'] = ""; // The order values can be left default.
        }
        
        print "Using method: ".$sCutMethod;
        // Debug output
        if($debug == true)
        {
            $this->DebugOutput($this->aName);
        }
    }
    
    public function DebugOutput($aInput)
    {
        print "<pre>";
        var_dump($aInput);
        print "</pre>";
    }
}



?>