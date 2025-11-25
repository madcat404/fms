<?php 

    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★  
    // [규칙]
    // 1. 변수 첫문자 대문자
    // 2. return값은 모두 대문자
    // 3. DB와 관련된 변수는 첫문자 대문자
    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ 
    // =========================================================================  
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.01.27>
    // Note: 공통변수
    // =========================================================================
    $Hyphen_today = date("Y-m-d");    
    $NoHyphen_today = date("Ymd");
    $NoHyphen_today6 = substr($NoHyphen_today,2,6);
    $DT = date("Y-m-d H:i:s");       
    $YY = substr($Hyphen_today,0,4);
    $YY2 = substr($Hyphen_today,2,2);
    $MM = substr($Hyphen_today,5,2);
    $MMDD = substr($NoHyphen_today,4,4);
    $W = date('w', strtotime($NoHyphen_today));
    $now_time = date("H:i:s");
    $Hyphen_today_zero = date("Y-m-d")." 00:00:00";   
    //월 0 제거
    if(substr($MM,0,1)==0) {
        $MM2=substr($MM,1,1);
    }    
    else {
        $MM2=$MM;
    }
    $YM = substr($Hyphen_today,0,7);
    $YM2 = substr($NoHyphen_today,0,6);
    $D = substr($Hyphen_today,8,2);    

    //주차구하기 
    $week = intval(date('W',mktime(0,0,0,$MM,$D,$YY)));
    $week1 = intval(date('W',mktime(0,0,0,$MM,$D-7,$YY)));
    $week2 = intval(date('W',mktime(0,0,0,$MM,$D-14,$YY)));
    $week3 = intval(date('W',mktime(0,0,0,$MM,$D-21,$YY)));
    $week4 = intval(date('W',mktime(0,0,0,$MM,$D-28,$YY)));
    $week5 = intval(date('W',mktime(0,0,0,$MM,$D-35,$YY)));
    $week6 = intval(date('W',mktime(0,0,0,$MM,$D-42,$YY)));
    ////////////////////////////////////////////날짜 변환은 DateConversion에서 하자////////////////////////////////////////////
    ////////////////////////////////////////////날짜 변환은 DateConversion에서 하자////////////////////////////////////////////
    ////////////////////////////////////////////ThisYear////////////////////////////////////////////
    $NoHyphen_ThisYear1M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear1M_FirstDay'); 
    $NoHyphen_ThisYear2M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear2M_FirstDay'); 
    $NoHyphen_ThisYear3M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear3M_FirstDay'); 
    $NoHyphen_ThisYear4M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear4M_FirstDay'); 
    $NoHyphen_ThisYear5M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear5M_FirstDay'); 
    $NoHyphen_ThisYear6M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear6M_FirstDay'); 
    $NoHyphen_ThisYear7M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear7M_FirstDay'); 
    $NoHyphen_ThisYear8M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear8M_FirstDay'); 
    $NoHyphen_ThisYear9M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear9M_FirstDay'); 
    $NoHyphen_ThisYear10M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear10M_FirstDay');
    $NoHyphen_ThisYear11M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear11M_FirstDay');
    $NoHyphen_ThisYear12M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear12M_FirstDay');

    $NoHyphen_ThisYear1M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear1M_LastDay');
    $NoHyphen_ThisYear2M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear2M_LastDay');
    $NoHyphen_ThisYear3M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear3M_LastDay');
    $NoHyphen_ThisYear4M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear4M_LastDay');
    $NoHyphen_ThisYear5M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear5M_LastDay');
    $NoHyphen_ThisYear6M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear6M_LastDay');
    $NoHyphen_ThisYear7M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear7M_LastDay');
    $NoHyphen_ThisYear8M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear8M_LastDay');
    $NoHyphen_ThisYear9M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear9M_LastDay');
    $NoHyphen_ThisYear10M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear10M_LastDay');
    $NoHyphen_ThisYear11M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear11M_LastDay');
    $NoHyphen_ThisYear12M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_ThisYear12M_LastDay');

    $Hyphen_ThisYear1M_YYMM = DateConversion($NoHyphen_ThisYear1M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear2M_YYMM = DateConversion($NoHyphen_ThisYear2M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear3M_YYMM = DateConversion($NoHyphen_ThisYear3M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear4M_YYMM = DateConversion($NoHyphen_ThisYear4M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear5M_YYMM = DateConversion($NoHyphen_ThisYear5M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear6M_YYMM = DateConversion($NoHyphen_ThisYear6M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear7M_YYMM = DateConversion($NoHyphen_ThisYear7M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear8M_YYMM = DateConversion($NoHyphen_ThisYear8M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear9M_YYMM = DateConversion($NoHyphen_ThisYear9M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear10M_YYMM = DateConversion($NoHyphen_ThisYear10M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear11M_YYMM = DateConversion($NoHyphen_ThisYear11M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_ThisYear12M_YYMM = DateConversion($NoHyphen_ThisYear12M_FirstDay, 'HyphenYYMM'); 

    $Hyphen_ThisYear1M_FirstDay = DateConversion($NoHyphen_ThisYear1M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear2M_FirstDay = DateConversion($NoHyphen_ThisYear2M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear3M_FirstDay = DateConversion($NoHyphen_ThisYear3M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear4M_FirstDay = DateConversion($NoHyphen_ThisYear4M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear5M_FirstDay = DateConversion($NoHyphen_ThisYear5M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear6M_FirstDay = DateConversion($NoHyphen_ThisYear6M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear7M_FirstDay = DateConversion($NoHyphen_ThisYear7M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear8M_FirstDay = DateConversion($NoHyphen_ThisYear8M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear9M_FirstDay = DateConversion($NoHyphen_ThisYear9M_FirstDay, 'Hyphen'); 
    $Hyphen_ThisYear10M_FirstDay = DateConversion($NoHyphen_ThisYear10M_FirstDay, 'Hyphen');
    $Hyphen_ThisYear11M_FirstDay = DateConversion($NoHyphen_ThisYear11M_FirstDay, 'Hyphen');
    $Hyphen_ThisYear12M_FirstDay = DateConversion($NoHyphen_ThisYear12M_FirstDay, 'Hyphen');

    $Hyphen_ThisYear1M_LastDay = DateConversion($NoHyphen_ThisYear1M_LastDay, 'Hyphen');
    $Hyphen_ThisYear2M_LastDay = DateConversion($NoHyphen_ThisYear2M_LastDay, 'Hyphen');
    $Hyphen_ThisYear3M_LastDay = DateConversion($NoHyphen_ThisYear3M_LastDay, 'Hyphen');
    $Hyphen_ThisYear4M_LastDay = DateConversion($NoHyphen_ThisYear4M_LastDay, 'Hyphen');
    $Hyphen_ThisYear5M_LastDay = DateConversion($NoHyphen_ThisYear5M_LastDay, 'Hyphen');
    $Hyphen_ThisYear6M_LastDay = DateConversion($NoHyphen_ThisYear6M_LastDay, 'Hyphen');
    $Hyphen_ThisYear7M_LastDay = DateConversion($NoHyphen_ThisYear7M_LastDay, 'Hyphen');
    $Hyphen_ThisYear8M_LastDay = DateConversion($NoHyphen_ThisYear8M_LastDay, 'Hyphen');
    $Hyphen_ThisYear9M_LastDay = DateConversion($NoHyphen_ThisYear9M_LastDay, 'Hyphen');
    $Hyphen_ThisYear10M_LastDay = DateConversion($NoHyphen_ThisYear10M_LastDay, 'Hyphen');
    $Hyphen_ThisYear11M_LastDay = DateConversion($NoHyphen_ThisYear11M_LastDay, 'Hyphen');
    $Hyphen_ThisYear12M_LastDay = DateConversion($NoHyphen_ThisYear12M_LastDay, 'Hyphen');

    ////////////////////////////////////////////1YearAgo////////////////////////////////////////////
    $NoHyphen_1YearAgo1M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo1M_FirstDay');
    $NoHyphen_1YearAgo2M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo2M_FirstDay');
    $NoHyphen_1YearAgo3M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo3M_FirstDay');
    $NoHyphen_1YearAgo4M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo4M_FirstDay');
    $NoHyphen_1YearAgo5M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo5M_FirstDay');
    $NoHyphen_1YearAgo6M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo6M_FirstDay');
    $NoHyphen_1YearAgo7M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo7M_FirstDay');
    $NoHyphen_1YearAgo8M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo8M_FirstDay');
    $NoHyphen_1YearAgo9M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo9M_FirstDay');
    $NoHyphen_1YearAgo10M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo10M_FirstDay');
    $NoHyphen_1YearAgo11M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo11M_FirstDay');
    $NoHyphen_1YearAgo12M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo12M_FirstDay');

    $NoHyphen_1YearAgo1M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo1M_LastDay');
    $NoHyphen_1YearAgo2M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo2M_LastDay');
    $NoHyphen_1YearAgo3M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo3M_LastDay');
    $NoHyphen_1YearAgo4M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo4M_LastDay');
    $NoHyphen_1YearAgo5M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo5M_LastDay');
    $NoHyphen_1YearAgo6M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo6M_LastDay');
    $NoHyphen_1YearAgo7M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo7M_LastDay');
    $NoHyphen_1YearAgo8M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo8M_LastDay');
    $NoHyphen_1YearAgo9M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo9M_LastDay');
    $NoHyphen_1YearAgo10M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo10M_LastDay');
    $NoHyphen_1YearAgo11M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo11M_LastDay');
    $NoHyphen_1YearAgo12M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_1YearAgo12M_LastDay');

    $Hyphen_1YearAgo1M_YYMM = DateConversion($NoHyphen_1YearAgo1M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo2M_YYMM = DateConversion($NoHyphen_1YearAgo2M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo3M_YYMM = DateConversion($NoHyphen_1YearAgo3M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo4M_YYMM = DateConversion($NoHyphen_1YearAgo4M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo5M_YYMM = DateConversion($NoHyphen_1YearAgo5M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo6M_YYMM = DateConversion($NoHyphen_1YearAgo6M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo7M_YYMM = DateConversion($NoHyphen_1YearAgo7M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo8M_YYMM = DateConversion($NoHyphen_1YearAgo8M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo9M_YYMM = DateConversion($NoHyphen_1YearAgo9M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo10M_YYMM = DateConversion($NoHyphen_1YearAgo10M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo11M_YYMM = DateConversion($NoHyphen_1YearAgo11M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_1YearAgo12M_YYMM = DateConversion($NoHyphen_1YearAgo12M_FirstDay, 'HyphenYYMM'); 

    $Hyphen_1YearAgo1M_FirstDay = DateConversion($NoHyphen_1YearAgo1M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo2M_FirstDay = DateConversion($NoHyphen_1YearAgo2M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo3M_FirstDay = DateConversion($NoHyphen_1YearAgo3M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo4M_FirstDay = DateConversion($NoHyphen_1YearAgo4M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo5M_FirstDay = DateConversion($NoHyphen_1YearAgo5M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo6M_FirstDay = DateConversion($NoHyphen_1YearAgo6M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo7M_FirstDay = DateConversion($NoHyphen_1YearAgo7M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo8M_FirstDay = DateConversion($NoHyphen_1YearAgo8M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo9M_FirstDay = DateConversion($NoHyphen_1YearAgo9M_FirstDay, 'Hyphen'); 
    $Hyphen_1YearAgo10M_FirstDay = DateConversion($NoHyphen_1YearAgo10M_FirstDay, 'Hyphen');
    $Hyphen_1YearAgo11M_FirstDay = DateConversion($NoHyphen_1YearAgo11M_FirstDay, 'Hyphen');
    $Hyphen_1YearAgo12M_FirstDay = DateConversion($NoHyphen_1YearAgo12M_FirstDay, 'Hyphen');

    $Hyphen_1YearAgo1M_LastDay = DateConversion($NoHyphen_1YearAgo1M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo2M_LastDay = DateConversion($NoHyphen_1YearAgo2M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo3M_LastDay = DateConversion($NoHyphen_1YearAgo3M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo4M_LastDay = DateConversion($NoHyphen_1YearAgo4M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo5M_LastDay = DateConversion($NoHyphen_1YearAgo5M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo6M_LastDay = DateConversion($NoHyphen_1YearAgo6M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo7M_LastDay = DateConversion($NoHyphen_1YearAgo7M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo8M_LastDay = DateConversion($NoHyphen_1YearAgo8M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo9M_LastDay = DateConversion($NoHyphen_1YearAgo9M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo10M_LastDay = DateConversion($NoHyphen_1YearAgo10M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo11M_LastDay = DateConversion($NoHyphen_1YearAgo11M_LastDay, 'Hyphen');
    $Hyphen_1YearAgo12M_LastDay = DateConversion($NoHyphen_1YearAgo12M_LastDay, 'Hyphen');

    ////////////////////////////////////////////2YearAgo////////////////////////////////////////////
    $NoHyphen_2YearAgo1M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo1M_FirstDay');
    $NoHyphen_2YearAgo2M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo2M_FirstDay');
    $NoHyphen_2YearAgo3M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo3M_FirstDay');
    $NoHyphen_2YearAgo4M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo4M_FirstDay');
    $NoHyphen_2YearAgo5M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo5M_FirstDay');
    $NoHyphen_2YearAgo6M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo6M_FirstDay');
    $NoHyphen_2YearAgo7M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo7M_FirstDay');
    $NoHyphen_2YearAgo8M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo8M_FirstDay');
    $NoHyphen_2YearAgo9M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo9M_FirstDay');
    $NoHyphen_2YearAgo10M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo10M_FirstDay');
    $NoHyphen_2YearAgo11M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo11M_FirstDay');
    $NoHyphen_2YearAgo12M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo12M_FirstDay');

    $NoHyphen_2YearAgo1M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo1M_LastDay');
    $NoHyphen_2YearAgo2M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo2M_LastDay');
    $NoHyphen_2YearAgo3M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo3M_LastDay');
    $NoHyphen_2YearAgo4M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo4M_LastDay');
    $NoHyphen_2YearAgo5M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo5M_LastDay');
    $NoHyphen_2YearAgo6M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo6M_LastDay');
    $NoHyphen_2YearAgo7M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo7M_LastDay');
    $NoHyphen_2YearAgo8M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo8M_LastDay');
    $NoHyphen_2YearAgo9M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo9M_LastDay');
    $NoHyphen_2YearAgo10M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo10M_LastDay');
    $NoHyphen_2YearAgo11M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo11M_LastDay');
    $NoHyphen_2YearAgo12M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_2YearAgo12M_LastDay');

    $Hyphen_2YearAgo1M_YYMM = DateConversion($NoHyphen_2YearAgo1M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo2M_YYMM = DateConversion($NoHyphen_2YearAgo2M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo3M_YYMM = DateConversion($NoHyphen_2YearAgo3M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo4M_YYMM = DateConversion($NoHyphen_2YearAgo4M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo5M_YYMM = DateConversion($NoHyphen_2YearAgo5M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo6M_YYMM = DateConversion($NoHyphen_2YearAgo6M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo7M_YYMM = DateConversion($NoHyphen_2YearAgo7M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo8M_YYMM = DateConversion($NoHyphen_2YearAgo8M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo9M_YYMM = DateConversion($NoHyphen_2YearAgo9M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo10M_YYMM = DateConversion($NoHyphen_2YearAgo10M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo11M_YYMM = DateConversion($NoHyphen_2YearAgo11M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_2YearAgo12M_YYMM = DateConversion($NoHyphen_2YearAgo12M_FirstDay, 'HyphenYYMM'); 

    $Hyphen_2YearAgo1M_FirstDay = DateConversion($NoHyphen_2YearAgo1M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo2M_FirstDay = DateConversion($NoHyphen_2YearAgo2M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo3M_FirstDay = DateConversion($NoHyphen_2YearAgo3M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo4M_FirstDay = DateConversion($NoHyphen_2YearAgo4M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo5M_FirstDay = DateConversion($NoHyphen_2YearAgo5M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo6M_FirstDay = DateConversion($NoHyphen_2YearAgo6M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo7M_FirstDay = DateConversion($NoHyphen_2YearAgo7M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo8M_FirstDay = DateConversion($NoHyphen_2YearAgo8M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo9M_FirstDay = DateConversion($NoHyphen_2YearAgo9M_FirstDay, 'Hyphen'); 
    $Hyphen_2YearAgo10M_FirstDay = DateConversion($NoHyphen_2YearAgo10M_FirstDay, 'Hyphen');
    $Hyphen_2YearAgo11M_FirstDay = DateConversion($NoHyphen_2YearAgo11M_FirstDay, 'Hyphen');
    $Hyphen_2YearAgo12M_FirstDay = DateConversion($NoHyphen_2YearAgo12M_FirstDay, 'Hyphen');

    $Hyphen_2YearAgo1M_LastDay = DateConversion($NoHyphen_2YearAgo1M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo2M_LastDay = DateConversion($NoHyphen_2YearAgo2M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo3M_LastDay = DateConversion($NoHyphen_2YearAgo3M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo4M_LastDay = DateConversion($NoHyphen_2YearAgo4M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo5M_LastDay = DateConversion($NoHyphen_2YearAgo5M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo6M_LastDay = DateConversion($NoHyphen_2YearAgo6M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo7M_LastDay = DateConversion($NoHyphen_2YearAgo7M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo8M_LastDay = DateConversion($NoHyphen_2YearAgo8M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo9M_LastDay = DateConversion($NoHyphen_2YearAgo9M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo10M_LastDay = DateConversion($NoHyphen_2YearAgo10M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo11M_LastDay = DateConversion($NoHyphen_2YearAgo11M_LastDay, 'Hyphen');
    $Hyphen_2YearAgo12M_LastDay = DateConversion($NoHyphen_2YearAgo12M_LastDay, 'Hyphen');

    ////////////////////////////////////////////3YearAgo////////////////////////////////////////////
    $NoHyphen_3YearAgo1M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo1M_FirstDay');
    $NoHyphen_3YearAgo2M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo2M_FirstDay');
    $NoHyphen_3YearAgo3M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo3M_FirstDay');
    $NoHyphen_3YearAgo4M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo4M_FirstDay');
    $NoHyphen_3YearAgo5M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo5M_FirstDay');
    $NoHyphen_3YearAgo6M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo6M_FirstDay');
    $NoHyphen_3YearAgo7M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo7M_FirstDay');
    $NoHyphen_3YearAgo8M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo8M_FirstDay');
    $NoHyphen_3YearAgo9M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo9M_FirstDay');
    $NoHyphen_3YearAgo10M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo10M_FirstDay');
    $NoHyphen_3YearAgo11M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo11M_FirstDay');
    $NoHyphen_3YearAgo12M_FirstDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo12M_FirstDay');

    $NoHyphen_3YearAgo1M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo1M_LastDay');
    $NoHyphen_3YearAgo2M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo2M_LastDay');
    $NoHyphen_3YearAgo3M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo3M_LastDay');
    $NoHyphen_3YearAgo4M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo4M_LastDay');
    $NoHyphen_3YearAgo5M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo5M_LastDay');
    $NoHyphen_3YearAgo6M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo6M_LastDay');
    $NoHyphen_3YearAgo7M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo7M_LastDay');
    $NoHyphen_3YearAgo8M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo8M_LastDay');
    $NoHyphen_3YearAgo9M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo9M_LastDay');
    $NoHyphen_3YearAgo10M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo10M_LastDay');
    $NoHyphen_3YearAgo11M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo11M_LastDay');
    $NoHyphen_3YearAgo12M_LastDay = DateConversion(date("Ymd"), 'NoHyphen_3YearAgo12M_LastDay');

    $Hyphen_3YearAgo1M_YYMM = DateConversion($NoHyphen_3YearAgo1M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo2M_YYMM = DateConversion($NoHyphen_3YearAgo2M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo3M_YYMM = DateConversion($NoHyphen_3YearAgo3M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo4M_YYMM = DateConversion($NoHyphen_3YearAgo4M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo5M_YYMM = DateConversion($NoHyphen_3YearAgo5M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo6M_YYMM = DateConversion($NoHyphen_3YearAgo6M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo7M_YYMM = DateConversion($NoHyphen_3YearAgo7M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo8M_YYMM = DateConversion($NoHyphen_3YearAgo8M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo9M_YYMM = DateConversion($NoHyphen_3YearAgo9M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo10M_YYMM = DateConversion($NoHyphen_3YearAgo10M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo11M_YYMM = DateConversion($NoHyphen_3YearAgo11M_FirstDay, 'HyphenYYMM'); 
    $Hyphen_3YearAgo12M_YYMM = DateConversion($NoHyphen_3YearAgo12M_FirstDay, 'HyphenYYMM'); 

    $Hyphen_3YearAgo1M_FirstDay = DateConversion($NoHyphen_3YearAgo1M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo2M_FirstDay = DateConversion($NoHyphen_3YearAgo2M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo3M_FirstDay = DateConversion($NoHyphen_3YearAgo3M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo4M_FirstDay = DateConversion($NoHyphen_3YearAgo4M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo5M_FirstDay = DateConversion($NoHyphen_3YearAgo5M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo6M_FirstDay = DateConversion($NoHyphen_3YearAgo6M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo7M_FirstDay = DateConversion($NoHyphen_3YearAgo7M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo8M_FirstDay = DateConversion($NoHyphen_3YearAgo8M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo9M_FirstDay = DateConversion($NoHyphen_3YearAgo9M_FirstDay, 'Hyphen'); 
    $Hyphen_3YearAgo10M_FirstDay = DateConversion($NoHyphen_3YearAgo10M_FirstDay, 'Hyphen');
    $Hyphen_3YearAgo11M_FirstDay = DateConversion($NoHyphen_3YearAgo11M_FirstDay, 'Hyphen');
    $Hyphen_3YearAgo12M_FirstDay = DateConversion($NoHyphen_3YearAgo12M_FirstDay, 'Hyphen');

    $Hyphen_3YearAgo1M_LastDay = DateConversion($NoHyphen_3YearAgo1M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo2M_LastDay = DateConversion($NoHyphen_3YearAgo2M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo3M_LastDay = DateConversion($NoHyphen_3YearAgo3M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo4M_LastDay = DateConversion($NoHyphen_3YearAgo4M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo5M_LastDay = DateConversion($NoHyphen_3YearAgo5M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo6M_LastDay = DateConversion($NoHyphen_3YearAgo6M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo7M_LastDay = DateConversion($NoHyphen_3YearAgo7M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo8M_LastDay = DateConversion($NoHyphen_3YearAgo8M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo9M_LastDay = DateConversion($NoHyphen_3YearAgo9M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo10M_LastDay = DateConversion($NoHyphen_3YearAgo10M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo11M_LastDay = DateConversion($NoHyphen_3YearAgo11M_LastDay, 'Hyphen');
    $Hyphen_3YearAgo12M_LastDay = DateConversion($NoHyphen_3YearAgo12M_LastDay, 'Hyphen');

    ////////////////////////////////////////////날짜 변환은 DateConversion에서 하자////////////////////////////////////////////
    ////////////////////////////////////////////날짜 변환은 DateConversion에서 하자////////////////////////////////////////////
    $Plus1Day = date("Y-m-d", strtotime(date("Y-m-d"). '+1 days'));
    $Plus6Day = date("Y-m-d", strtotime(date("Y-m-d"). '+6 days'));
    $Minus1Day = date("Y-m-d", strtotime(date("Y-m-d"). '-1 days'));
    $Minus2Day = date("Y-m-d", strtotime(date("Y-m-d"). '-2 days'));
    $Minus3Day = date("Y-m-d", strtotime(date("Y-m-d"). '-3 days'));    
    $Minus10Day = date("Y-m-d", strtotime(date("Y-m-d"). '-10 days'));
    $Minus7Day = date("Y-m-d", strtotime(date("Y-m-d"). '-7 days'));
    $Minus1Day2 = date("Ymd", strtotime(date("Y-m-d"). '-1 days'));
    $Plus1Day2 = (new DateTime())->modify('+1 days')->format('Ymd');
    $MMDD2 = substr($Minus1Day2,4,4);
    $Minus3Day2 = date("Ymd", strtotime(date("Y-m-d"). '-3 days'));
    //내년
    $Plus1year = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of +1 year'));
    $Plus1YY = substr($Plus1year,0,4);
    //전년
    $Minus1year = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -1 year'));
    $Minus1YY = substr($Minus1year,0,4);
    $Minus1year_YM = substr($Minus1year,0,7);    

    //전전년
    $Minus2year = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -2 year'));
    $Minus2YY = substr($Minus2year,0,4);
    $Minus2year_YM = substr($Minus2year,0,7);
    //전전전년
    $Minus3year = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -3 year'));
    $Minus3YY = substr($Minus3year,0,4);
    $Minus3year_YM = substr($Minus3year,0,7);
    //전년전월
    $Minus1yearMonth = date("Y-m-d", strtotime(date("Y-m-d"). '-1 year first day of -1 month'));
    $Minus1yearMonth_YM = substr($Minus1yearMonth,0,7);
    //전년다음월
    $Plus1yearMonth = date("Y-m-d", strtotime(date("Y-m-d"). '-1 year first day of +1 month'));
    $Plus1yearMonth_YM = substr($Plus1yearMonth,0,7);
    //전월
    $Minus1Month = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -1 month'));
    $Minus1MM = substr($Minus1Month,5,2);
    $Minus1YM = substr($Minus1Month,0,7);
    $Minus1Month2 = date("Ymd", strtotime(date("Y-m-d"). 'first day of -1 month'));
    $Minus1YM2 = substr($Minus1Month2,0,6);
    //다음달
    $Plus1Month = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of +1 month'));
    $Plus1MM = substr($Plus1Month,5,2);
    $Plus1YM = substr($Plus1Month,0,7);
    //전전월
    $Minus2Month = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -2 month'));
    $Minus2MM = substr($Minus2Month,5,2);
    $Minus2YM = substr($Minus2Month,0,7);
    //3개월 전 (일일업무보고 물류탭에서 사용)
    $Minus3Month = date("Y-m-d", strtotime(date("Y-m-d"). 'first day of -3 month'));
    //3개월 전 (올바로 API 사용)
    $Minus3Month2 = date("Ymd", strtotime(date("Y-m-d"). 'first day of -3 month'));

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <25.05.28>
    // Note: 업로드 파일 해시 확인
    // =========================================================================  
    function checkFileHash($filePath) { 
        include_once '../DB/DB2.php';

        // 파일 존재 여부 체크
        if (!file_exists($filePath)) {
            return false;
        }

        // 파일의 MD5 해시값 생성
        $hash = hash_file('md5', $filePath);
        if ($hash === false) {
            return false;
        }

        // DB 연결 확인
        if (!isset($connect) || !$connect) {
            return false;
        }

        // hash 테이블에서 해시값 조회
        $Query_HASH = "SELECT HASH FROM CONNECT.dbo.BLACKLIST_HASH WHERE HASH ='$hash'";              
        $Result_HASH = sqlsrv_query($connect, $Query_HASH); // params, options 제거 또는 정의 필요

        if ($Result_HASH === false) {
            // 쿼리 실패 시 false 반환
            return false;
        }

        // 결과가 false가 아닐 때만 num_rows 호출
        $Count_HASH = (is_resource($Result_HASH) || is_object($Result_HASH)) ? sqlsrv_num_rows($Result_HASH) : 0;

        if($Count_HASH > 0) {
            return true;
        }        

        return false;
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <25.03.06>
    // Last Modified: <25.11.07> - Removed debug logs, confirmed parameterized query.
    // Note: 시험실 일일점검 확인(메일보고용)
    // =========================================================================  
    function checklist($connect, $Data_CheckReport, $EQUIPMENT_NUM){
        $checker_alive='N';

        // This query can also be optimized by fetching all checklist items at once outside the loop,
        // but for now, we'll fix the immediate issue.
        $Query_SelectList2 = "SELECT * FROM CONNECT.dbo.TEST_ROOM_CHECKLIST where EQUIPMENT_NUM= ?";
        $params_SelectList2 = [$EQUIPMENT_NUM];
        $Result_SelectList2 = sqlsrv_query($connect, $Query_SelectList2, $params_SelectList2);

        if ($Result_SelectList2) {
            while($Data_SelectList2 = sqlsrv_fetch_array($Result_SelectList2)) {
                $merge3 = "equipment".$Data_SelectList2['EQUIPMENT_NUM'].$Data_SelectList2['EQUIPMENT_SEQ'];

                if(isset($Data_CheckReport[$merge3]) && $Data_CheckReport[$merge3]=='on') {
                    $checker_alive="Y";
                    break; // Optimization: Exit loop once a check is found.
                }
            }
        }

        return $checker_alive;
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <25.01.23>
    // Note: 공통 쿼리 실행 함수 (SQL Injection 방지용 Prepared Statement 사용)
    // =========================================================================  
    function executeQuery($connection, $query, $params = []) {
        $stmt = sqlsrv_prepare($connection, $query, $params);
        if (!$stmt) {
            error_log("SQL Error: " . print_r(sqlsrv_errors(), true));
            return null;
        }
        if (!sqlsrv_execute($stmt)) {
            error_log("Execution Error: " . print_r(sqlsrv_errors(), true));
            return null;
        }
        return $stmt;
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.12.16>
    // Note: 해당 년월의 1일로 DateTime 객체 생성
    // =========================================================================  
    function DateConversion($ymd, $option) {
        $year = substr($ymd, 0, 4);
        $yearMinusOne = $year - 1;
        $yearMinusTwo = $year - 2; 
        $yearMinusThree = $year - 3;        

        if ($option == 'NoHyphen') {
            $date = new DateTime("$ymd");
            $date->modify('last day of this month');
            return $date->format('Ymd');
        } elseif ($option == 'Hyphen') {
            $date = new DateTime("$ymd");
            return $date->format('Y-m-d');
        } elseif ($option == 'HyphenYYMM') {
            $date = new DateTime("$ymd");
            return $date->format('Y-m');
        } elseif ($option == 'day') {
            $date = new DateTime("$ymd");
            $date->modify('last day of this month');
            return $date->format('d');
        } 
        /////////////////1YearAgo_YYMM/////////////////
        elseif ($option == 'Hyphen_1YearAgo1M_YYMM') {
            return $yearMinusOne . "-01"; 
        } elseif ($option == 'Hyphen_1YearAgo2M_YYMM') {
            return $yearMinusOne . "-02"; 
        } elseif ($option == 'Hyphen_1YearAgo3M_YYMM') {
            return $yearMinusOne . "-03"; 
        } elseif ($option == 'Hyphen_1YearAgo4M_YYMM') {
            return $yearMinusOne . "-04"; 
        } elseif ($option == 'Hyphen_1YearAgo5M_YYMM') {
            return $yearMinusOne . "-05"; 
        } elseif ($option == 'Hyphen_1YearAgo6M_YYMM') {
            return $yearMinusOne . "-06"; 
        } elseif ($option == 'Hyphen_1YearAgo7M_YYMM') {
            return $yearMinusOne . "-07"; 
        } elseif ($option == 'Hyphen_1YearAgo8M_YYMM') {
            return $yearMinusOne . "-08"; 
        } elseif ($option == 'Hyphen_1YearAgo9M_YYMM') {
            return $yearMinusOne . "-09"; 
        } elseif ($option == 'Hyphen_1YearAgo10M_YYMM') {
            return $yearMinusOne . "-10"; 
        } elseif ($option == 'Hyphen_1YearAgo11M_YYMM') {
            return $yearMinusOne . "-11"; 
        } elseif ($option == 'Hyphen_1YearAgo12M_YYMM') {
            return $yearMinusOne . "-12"; 
        } 
        /////////////////2YearAgo_YYMM/////////////////
        elseif ($option == 'Hyphen_2YearAgo1M_YYMM') {
            return $yearMinusTwo . "-01"; 
        } elseif ($option == 'Hyphen_2YearAgo2M_YYMM') {
            return $yearMinusTwo . "-02"; 
        } elseif ($option == 'Hyphen_2YearAgo3M_YYMM') {
            return $yearMinusTwo . "-03"; 
        } elseif ($option == 'Hyphen_2YearAgo4M_YYMM') {
            return $yearMinusTwo . "-04"; 
        } elseif ($option == 'Hyphen_2YearAgo5M_YYMM') {
            return $yearMinusTwo . "-05"; 
        } elseif ($option == 'Hyphen_2YearAgo6M_YYMM') {
            return $yearMinusTwo . "-06"; 
        } elseif ($option == 'Hyphen_2YearAgo7M_YYMM') {
            return $yearMinusTwo . "-07"; 
        } elseif ($option == 'Hyphen_2YearAgo8M_YYMM') {
            return $yearMinusTwo . "-08"; 
        } elseif ($option == 'Hyphen_2YearAgo9M_YYMM') {
            return $yearMinusTwo . "-09"; 
        } elseif ($option == 'Hyphen_2YearAgo10M_YYMM') {
            return $yearMinusTwo . "-10"; 
        } elseif ($option == 'Hyphen_2YearAgo11M_YYMM') {
            return $yearMinusTwo . "-11"; 
        } elseif ($option == 'Hyphen_2YearAgo12M_YYMM') {
            return $yearMinusTwo . "-12"; 
        } 
        /////////////////ThisYear_FirstDay/////////////////
        elseif ($option == 'NoHyphen_ThisYear1M_FirstDay') {
            return $year . "0101"; 
        } elseif ($option == 'NoHyphen_ThisYear2M_FirstDay') {
            return $year . "0201"; 
        } elseif ($option == 'NoHyphen_ThisYear3M_FirstDay') {
            return $year . "0301"; 
        } elseif ($option == 'NoHyphen_ThisYear4M_FirstDay') {
            return $year . "0401"; 
        } elseif ($option == 'NoHyphen_ThisYear5M_FirstDay') {
            return $year . "0501"; 
        } elseif ($option == 'NoHyphen_ThisYear6M_FirstDay') {
            return $year . "0601"; 
        } elseif ($option == 'NoHyphen_ThisYear7M_FirstDay') {
            return $year . "0701"; 
        } elseif ($option == 'NoHyphen_ThisYear8M_FirstDay') {
            return $year . "0801"; 
        } elseif ($option == 'NoHyphen_ThisYear9M_FirstDay') {
            return $year . "0901"; 
        } elseif ($option == 'NoHyphen_ThisYear10M_FirstDay') {
            return $year . "1001"; 
        } elseif ($option == 'NoHyphen_ThisYear11M_FirstDay') {
            return $year . "1101"; 
        } elseif ($option == 'NoHyphen_ThisYear12M_FirstDay') {
            return $year . "1201"; 
        } 
        /////////////////ThisYear_LastDay/////////////////
        elseif ($option == 'NoHyphen_ThisYear1M_LastDay') {
            return $year . "0131"; 
        } elseif ($option == 'NoHyphen_ThisYear2M_LastDay') {
            return $year . "0231"; 
        } elseif ($option == 'NoHyphen_ThisYear3M_LastDay') {
            return $year . "0331"; 
        } elseif ($option == 'NoHyphen_ThisYear4M_LastDay') {
            return $year . "0431"; 
        } elseif ($option == 'NoHyphen_ThisYear5M_LastDay') {
            return $year . "0531"; 
        } elseif ($option == 'NoHyphen_ThisYear6M_LastDay') {
            return $year . "0631"; 
        } elseif ($option == 'NoHyphen_ThisYear7M_LastDay') {
            return $year . "0731"; 
        } elseif ($option == 'NoHyphen_ThisYear8M_LastDay') {
            return $year . "0831"; 
        } elseif ($option == 'NoHyphen_ThisYear9M_LastDay') {
            return $year . "0931"; 
        } elseif ($option == 'NoHyphen_ThisYear10M_LastDay') {
            return $year . "1031"; 
        } elseif ($option == 'NoHyphen_ThisYear11M_LastDay') {
            return $year . "1131"; 
        } elseif ($option == 'NoHyphen_ThisYear12M_LastDay') {
            return $year . "1231"; 
        } 
        /////////////////1YearAgo_FirstDay/////////////////
        elseif ($option == 'NoHyphen_1YearAgo1M_FirstDay') {
            return $yearMinusOne . "0101";
        } elseif ($option == 'NoHyphen_1YearAgo2M_FirstDay') {
            return $yearMinusOne . "0201";
        } elseif ($option == 'NoHyphen_1YearAgo3M_FirstDay') {
            return $yearMinusOne . "0301";
        } elseif ($option == 'NoHyphen_1YearAgo4M_FirstDay') {
            return $yearMinusOne . "0401";
        } elseif ($option == 'NoHyphen_1YearAgo5M_FirstDay') {
            return $yearMinusOne . "0501";
        } elseif ($option == 'NoHyphen_1YearAgo6M_FirstDay') {
            return $yearMinusOne . "0601";
        } elseif ($option == 'NoHyphen_1YearAgo7M_FirstDay') {
            return $yearMinusOne . "0701";
        } elseif ($option == 'NoHyphen_1YearAgo8M_FirstDay') {
            return $yearMinusOne . "0801";
        } elseif ($option == 'NoHyphen_1YearAgo9M_FirstDay') {
            return $yearMinusOne . "0901";
        } elseif ($option == 'NoHyphen_1YearAgo10M_FirstDay') {
            return $yearMinusOne . "1001";
        } elseif ($option == 'NoHyphen_1YearAgo11M_FirstDay') {
            return $yearMinusOne . "1101";
        } elseif ($option == 'NoHyphen_1YearAgo12M_FirstDay') {
            return $yearMinusOne . "1201";
        }
        /////////////////1YearAgo_LastDay/////////////////
        elseif ($option == 'NoHyphen_1YearAgo1M_LastDay') {
            return $yearMinusOne . "0131"; 
        } elseif ($option == 'NoHyphen_1YearAgo2M_LastDay') {
            return $yearMinusOne . "0231"; 
        } elseif ($option == 'NoHyphen_1YearAgo3M_LastDay') {
            return $yearMinusOne . "0331"; 
        } elseif ($option == 'NoHyphen_1YearAgo4M_LastDay') {
            return $yearMinusOne . "0431"; 
        } elseif ($option == 'NoHyphen_1YearAgo5M_LastDay') {
            return $yearMinusOne . "0531"; 
        } elseif ($option == 'NoHyphen_1YearAgo6M_LastDay') {
            return $yearMinusOne . "0631"; 
        } elseif ($option == 'NoHyphen_1YearAgo7M_LastDay') {
            return $yearMinusOne . "0731"; 
        } elseif ($option == 'NoHyphen_1YearAgo8M_LastDay') {
            return $yearMinusOne . "0831"; 
        } elseif ($option == 'NoHyphen_1YearAgo9M_LastDay') {
            return $yearMinusOne . "0931"; 
        } elseif ($option == 'NoHyphen_1YearAgo10M_LastDay') {
            return $yearMinusOne . "1031"; 
        } elseif ($option == 'NoHyphen_1YearAgo11M_LastDay') {
            return $yearMinusOne . "1131"; 
        } elseif ($option == 'NoHyphen_1YearAgo12M_LastDay') {
            return $yearMinusOne . "1231"; 
        } 
        /////////////////2YearAgo_FirstDay/////////////////
        elseif ($option == 'NoHyphen_2YearAgo1M_FirstDay') {
            return $yearMinusTwo . "0101";
        } elseif ($option == 'NoHyphen_2YearAgo2M_FirstDay') {
            return $yearMinusTwo . "0201";
        } elseif ($option == 'NoHyphen_2YearAgo3M_FirstDay') {
            return $yearMinusTwo . "0301";
        } elseif ($option == 'NoHyphen_2YearAgo4M_FirstDay') {
            return $yearMinusTwo . "0401";
        } elseif ($option == 'NoHyphen_2YearAgo5M_FirstDay') {
            return $yearMinusTwo . "0501";
        } elseif ($option == 'NoHyphen_2YearAgo6M_FirstDay') {
            return $yearMinusTwo . "0601";
        } elseif ($option == 'NoHyphen_2YearAgo7M_FirstDay') {
            return $yearMinusTwo . "0701";
        } elseif ($option == 'NoHyphen_2YearAgo8M_FirstDay') {
            return $yearMinusTwo . "0801";
        } elseif ($option == 'NoHyphen_2YearAgo9M_FirstDay') {
            return $yearMinusTwo . "0901";
        } elseif ($option == 'NoHyphen_2YearAgo10M_FirstDay') {
            return $yearMinusTwo . "1001";
        } elseif ($option == 'NoHyphen_2YearAgo11M_FirstDay') {
            return $yearMinusTwo . "1101";
        } elseif ($option == 'NoHyphen_2YearAgo12M_FirstDay') {
            return $yearMinusTwo . "1201";
        }
        /////////////////2YearAgo_LastDay/////////////////
        elseif ($option == 'NoHyphen_2YearAgo1M_LastDay') {
            return $yearMinusTwo . "0131"; 
        } elseif ($option == 'NoHyphen_2YearAgo2M_LastDay') {
            return $yearMinusTwo . "0231"; 
        } elseif ($option == 'NoHyphen_2YearAgo3M_LastDay') {
            return $yearMinusTwo . "0331"; 
        } elseif ($option == 'NoHyphen_2YearAgo4M_LastDay') {
            return $yearMinusTwo . "0431"; 
        } elseif ($option == 'NoHyphen_2YearAgo5M_LastDay') {
            return $yearMinusTwo . "0531"; 
        } elseif ($option == 'NoHyphen_2YearAgo6M_LastDay') {
            return $yearMinusTwo . "0631"; 
        } elseif ($option == 'NoHyphen_2YearAgo7M_LastDay') {
            return $yearMinusTwo . "0731"; 
        } elseif ($option == 'NoHyphen_2YearAgo8M_LastDay') {
            return $yearMinusTwo . "0831"; 
        } elseif ($option == 'NoHyphen_2YearAgo9M_LastDay') {
            return $yearMinusTwo . "0931"; 
        } elseif ($option == 'NoHyphen_2YearAgo10M_LastDay') {
            return $yearMinusTwo . "1031"; 
        } elseif ($option == 'NoHyphen_2YearAgo11M_LastDay') {
            return $yearMinusTwo . "1131"; 
        } elseif ($option == 'NoHyphen_2YearAgo12M_LastDay') {
            return $yearMinusTwo . "1231"; 
        } 
        /////////////////3YearAgo_FirstDay/////////////////
        elseif ($option == 'NoHyphen_3YearAgo1M_FirstDay') {
            return $yearMinusThree . "0101";
        } elseif ($option == 'NoHyphen_3YearAgo2M_FirstDay') {
            return $yearMinusThree . "0201";
        } elseif ($option == 'NoHyphen_3YearAgo3M_FirstDay') {
            return $yearMinusThree . "0301";
        } elseif ($option == 'NoHyphen_3YearAgo4M_FirstDay') {
            return $yearMinusThree . "0401";
        } elseif ($option == 'NoHyphen_3YearAgo5M_FirstDay') {
            return $yearMinusThree . "0501";
        } elseif ($option == 'NoHyphen_3YearAgo6M_FirstDay') {
            return $yearMinusThree . "0601";
        } elseif ($option == 'NoHyphen_3YearAgo7M_FirstDay') {
            return $yearMinusThree . "0701";
        } elseif ($option == 'NoHyphen_3YearAgo8M_FirstDay') {
            return $yearMinusThree . "0801";
        } elseif ($option == 'NoHyphen_3YearAgo9M_FirstDay') {
            return $yearMinusThree . "0901";
        } elseif ($option == 'NoHyphen_3YearAgo10M_FirstDay') {
            return $yearMinusThree . "1001";
        } elseif ($option == 'NoHyphen_3YearAgo11M_FirstDay') {
            return $yearMinusThree . "1101";
        } elseif ($option == 'NoHyphen_3YearAgo12M_FirstDay') {
            return $yearMinusThree . "1201";
        }
        /////////////////3YearAgo_LastDay/////////////////
        elseif ($option == 'NoHyphen_3YearAgo1M_LastDay') {
            return $yearMinusThree . "0131"; 
        } elseif ($option == 'NoHyphen_3YearAgo2M_LastDay') {
            return $yearMinusThree . "0231"; 
        } elseif ($option == 'NoHyphen_3YearAgo3M_LastDay') {
            return $yearMinusThree . "0331"; 
        } elseif ($option == 'NoHyphen_3YearAgo4M_LastDay') {
            return $yearMinusThree . "0431"; 
        } elseif ($option == 'NoHyphen_3YearAgo5M_LastDay') {
            return $yearMinusThree . "0531"; 
        } elseif ($option == 'NoHyphen_3YearAgo6M_LastDay') {
            return $yearMinusThree . "0631"; 
        } elseif ($option == 'NoHyphen_3YearAgo7M_LastDay') {
            return $yearMinusThree . "0731"; 
        } elseif ($option == 'NoHyphen_3YearAgo8M_LastDay') {
            return $yearMinusThree . "0831"; 
        } elseif ($option == 'NoHyphen_3YearAgo9M_LastDay') {
            return $yearMinusThree . "0931"; 
        } elseif ($option == 'NoHyphen_3YearAgo10M_LastDay') {
            return $yearMinusThree . "1031"; 
        } elseif ($option == 'NoHyphen_3YearAgo11M_LastDay') {
            return $yearMinusThree . "1131"; 
        } elseif ($option == 'NoHyphen_3YearAgo12M_LastDay') {
            return $yearMinusThree . "1231"; 
        } 
        else {
            $date = new DateTime("$ymd");
            $date->modify('last day of this month');
            return $date->format('Y-m-d');
        }
    }


    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.11.27>
    // Note: 썸머타임 시행여부
    // =========================================================================  
    function SummerTime(string $timezone, string $date = 'now'): bool {
        try {
            // 주어진 시간대와 날짜로 DateTime 객체 생성
            $datetime = new DateTime($date, new DateTimeZone($timezone));
            // 해당 시간대의 GMT 오프셋 확인
            $offset = $datetime->getOffset();
            // 시간대의 표준 시간(GMT 오프셋) 확인
            $standardOffset = timezone_offset_get(new DateTimeZone($timezone), new DateTime('1970-01-01', new DateTimeZone($timezone)));
            // GMT 오프셋이 표준 시간 오프셋보다 크면 썸머타임 적용 중
            return $offset > $standardOffset;
        } catch (Exception $e) {
            // 예외 발생 시 false 반환
            return false;
        }
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.11.13>
    // Note: 홈페이지 접속상태 확인
    // =========================================================================  
    function homepage($url){
 
        $ch = curl_init($url);
    
        // cURL 옵션 설정
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 응답을 반환하도록 설정
        curl_setopt($ch, CURLOPT_NOBODY, true); // 헤더만 가져오기
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 타임아웃 설정 (10초)
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // 요청 실행
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // HTTP 상태 코드 가져오기
        
        curl_close($ch);
        
        return $httpCode;
    }
        
    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.11.13>
    // Note: erp 그룹코드명
    // =========================================================================  
    function ERP_GROUP($code){
 
        if($code=='0000') { $code_name="임원"; }
        elseif($code=='1000') { $code_name="마스터"; }
        elseif($code=='2100') { $code_name="인사"; }
        elseif($code=='2200') { $code_name="재무"; }
        elseif($code=='2201') { $code_name="재무팀장"; }
        elseif($code=='2300') { $code_name="시험"; }
        elseif($code=='2400') { $code_name="설계"; }
        elseif($code=='2500') { $code_name="원가"; }
        elseif($code=='2600') { $code_name="품질"; }
        elseif($code=='2700') { $code_name="생산"; }
        elseif($code=='2701') { $code_name="물류"; }
        elseif($code=='2800') { $code_name="퍼스트인(사무)"; }
        elseif($code=='2801') { $code_name="퍼스트인(현장)"; }
        elseif($code=='2802') { $code_name="퍼스트인(사무-물류)"; }
        elseif($code=='2803') { $code_name="퍼스트인(사무-설계)"; }
        elseif($code=='2804') { $code_name="퍼스트인(현장-품질)"; }
        elseif($code=='2805') { $code_name="퍼스트인(현장-ECU)"; }
        elseif($code=='2806') { $code_name="퍼스트인(현장2)"; }
        elseif($code=='2807') { $code_name="퍼스트인(현장-설계)"; }
        elseif($code=='2808') { $code_name="퍼스트인(현장-자재)"; }
        elseif($code=='2900') { $code_name="해외법인"; }
        elseif($code=='9000') { $code_name="웹유저"; }
        elseif($code=='WEB') { $code_name="웹"; }

        return $code_name;
    }
    
    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.09.19>
    // Note: 모바일 기기 접속 구분
    // =========================================================================  
    function isMobile() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $mobileAgents = ['Android', 'iPhone', 'iPad', 'iPod', 'Opera Mini', 'IEMobile', 'Mobile'];
    
        foreach ($mobileAgents as $agent) {
            if (strpos($userAgent, $agent) !== false) {
                return true;
            }
        }
        return false;
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <24.04.03>
    // Note: 품번 및 기타정보 추출
    // =========================================================================  
    function CROP2($barcode, $option){

        //wire-ecu 검사기 (노트북 검사기)
        if($option=='WireEcu') {
            //자동차 바코드에 ecu정보도 포함되어 있는 경우
            $barcode_length = strlen($barcode);
            $location1 = strpos($barcode, 'P');
            //////////////////////////////////////////////품번 추출//////////////////////////////////////////////
            //품번에 t가 들어가는 경우 대비
            $temp_string = substr($barcode, $location1+11, $barcode_length-$location1-11);
            $location2 = strpos($temp_string, 'T');
            $CD_ITEM = substr($barcode, $location1+1, $location2+10);    
            $item_length = strlen($CD_ITEM);
            IF(substr($CD_ITEM, -1)=='S' OR substr($CD_ITEM, -1)=='E' OR substr($CD_ITEM, -1)=='G') {
                IF(substr($CD_ITEM, -2)=='SE' or substr($CD_ITEM, -2)=='GS') {
                    $CD_ITEM=substr($CD_ITEM, 0, $item_length-2);
                }   
                ELSE {
                    $CD_ITEM=substr($CD_ITEM, 0, $item_length-1);
                }
            }  

            //아스키코드값 제거를 위해
            $CD_ITEM=substr($CD_ITEM, 0, 10);            

            //////////////////////////////////////////////추적코드 추출//////////////////////////////////////////////
            //고객사 바코드 양식 식별자(1자리), 제조일자(6자리), 부품4m/기타(5자리) -> +13자리 안에 c가 들어갈 가능성 회피
            $temp_string2 = substr($barcode, $location1+11+$location2+1, $barcode_length-$location1-11-$location2-1);
            $location3 = strpos($temp_string2, 'C'); 
            
            $TRACE_CODE= substr($barcode, $location1+11+$location2+1, $location3);
            $item_length2 = strlen($TRACE_CODE);
            IF(substr($TRACE_CODE, -1)=='M' OR substr($TRACE_CODE, -1)=='N' OR substr($TRACE_CODE, -1)=='A') { 
                IF(substr($TRACE_CODE, -2)=='MN' OR substr($TRACE_CODE, -2)=='AN' OR substr($TRACE_CODE, -2)=='AM') {
                    IF(substr($TRACE_CODE, -3)=='AMN') {            
                        $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-3);
                    } 
                    ELSE {
                        $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-2);
                    }
                } 
                ELSE {
                    $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-1);
                } 
            }

            //trace코드에서 로트날짜와 로트번호 추출
            $LOT_DATE=substr($TRACE_CODE, 0, 6);
            $LOT_NUM=substr($TRACE_CODE, 17, 4);        
            //////////////////////////////////////////////ECU코드 추출//////////////////////////////////////////////        
            $ECU_CODE= substr($barcode, $location1+11+$location2+$location3+2, 22);
            $ECU_CD_ITEM= substr($ECU_CODE, 0, 10);
            $ECU_LOT_DATE= substr($ECU_CODE, 10, 6);
            $ECU_LOT_NUM= substr($ECU_CODE, 16, 6);
        }

        return array($CD_ITEM, $TRACE_CODE, $LOT_DATE, $LOT_NUM, $ECU_CD_ITEM, $ECU_LOT_DATE, $ECU_LOT_NUM);
    }



    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <23.06.07>
    // Note: 엑셀 날짜형식을 php 날짜형식으로 변환
    // =========================================================================  
    function CovertEXCEL($dt){
        $t = ($dt-25569) * 86400-60*60*9;
        $t = round($t*10)/10;       

        return $t;
        //리턴값  date('Y-m-d' $t); 형식을 적용시킬것
    }



    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <23.05.22>
    // Note: 보드 펑션의 한계점을 개선한 펑션
    // =========================================================================  
    function BOARD2($size, $color, $title, $goal, $icon, $option, $shortcut){
        $title_safe = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $goal_safe = htmlspecialchars($goal, ENT_QUOTES, 'UTF-8');
        $option_safe = htmlspecialchars($option, ENT_QUOTES, 'UTF-8');
        $shortcut_safe = htmlspecialchars($shortcut, ENT_QUOTES, 'UTF-8');
        $html = '';
    
        if($option=='shortcut') {
            $html = "
                    <div class='col-xl-{$size} col-md-{$size}'>
                        <div class='card border-left-{$color} shadow h-100'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                        <div class='h5 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto'>
                                        <i class='{$icon} fa-2x text-gray-300'></i>
                                    </div>
                                </div>
                                <div class='row no-gutters align-items-center box-shadows-none bg-light mt-2'>
                                    <div class='col-auto mx-auto'>
                                        <a href='{$shortcut_safe}'>more info <i class='fas fa-arrow-circle-right fa-1x text-300'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        elseif($option=='normal') {             
            $html = "
                <div class='col-xl-{$size} col-md-{$size} mb-2'>
                    <div class='card border-left-{$color} shadow h-100 py-2'>
                        <div class='card-body'>
                            <div class='row no-gutters align-items-center'>
                                <div class='col mr-2'>
                                    <div class='text-xs font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                    <div class='h5 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                </div>
                                <div class='col-auto'>
                                    <i class='{$icon} fa-2x text-gray-300'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
            ";                
        }
        elseif($shortcut=='BB구역') {
            $html = "
                    <div class='col-xl-{$size} col-md-{$size} mb-2'>
                        <div class='card border-left-{$color} shadow h-100 py-5 px-4'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center h-100 py-5 px-1'>
                                    <div class='col mr-2'>
                                        <div class='h1 mb-0 font-weight-bold text-danger text-600 mb-1'><i class='fas fa-map-marker-alt fa-1x'></i>  {$option_safe}</div>
                                        <div class='text-lx font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='{$icon} fa-8x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        elseif($option=='pda_screen') {
            $html = "
                    <div class='col-xl-{$size} col-md-{$size} mb-2'>
                        <div class='card border-left-{$color} shadow h-100 py-1 px-4'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center py-3 px-1'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='fas fa-barcode fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                                <div class='row no-gutters align-items-center py-3 px-1'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-{$color} text-uppercase mb-1'>전체실적(BOX)</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>{$shortcut_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='{$icon} fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        elseif($option=='pda_finished') {
            $html = "
                    <div class='col-xl-{$size} col-md-{$size} mb-2'>
                        <div class='card border-left-{$color} shadow h-100 py-1 px-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center py-3 px-1'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='fas fa-truck fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                                <div class='row no-gutters align-items-center py-3 px-1'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-{$color} text-uppercase mb-1'>나의실적(BOX)</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>{$shortcut_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='{$icon} fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        elseif($option=='task') {
            $html = "
                    <div class='col-{$size} mb-2'>
                        <div class='card border-left-{$color} shadow h-100 py-1'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center h-50 py-2 px-2'>
                                    <div class='col mr-2' style='text-align: left;'>
                                        <div class='text-xs font-weight-bold text-{$color} mb-1'>{$title_safe}</div>
                                        <div class='h4 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='{$icon} fa-3x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>         
                ";   
        }
        else {
            $html = "
                    <div class='col-xl-{$size} col-md-{$size} mb-2'>
                        <div class='card border-left-{$color} shadow h-100 py-1 px-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center h-50 py-2 px-2'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-{$color} text-uppercase mb-1'>{$title_safe}</div>
                                        <div class='h4 mb-0 font-weight-bold text-gray-800'>{$goal_safe}</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='{$icon} fa-3x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        
        echo $html;
    }

    
    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <23.04.24>
    // Note: 전일 및 전일이 주말일 경우 금요일 선택
    // =========================================================================      
    function Yesterday($week) {
        $TodayWeek = date('w', strtotime($week));

        if($TodayWeek==1) {       
            $Yesterday = date("Y-m-d", strtotime(date("Y-m-d"). '-3 days'));
        }
        else {
            $Yesterday = date("Y-m-d", strtotime(date("Y-m-d"). '-1 days'));
        }

        return $Yesterday; 
    }


    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <23.02.27>
    // Note: 년월의 마지막 일 구하기
    // =========================================================================      
    function LastDay($year, $month) {
        $lastday = date('t', strtotime("$year-$month-01"));

        $last = $year."-".$month."-".$lastday;

        return $last; 
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.11.22>
    // Note: 권한없는 접근에 대한 알림창
    // =========================================================================      
    function Confirm() {
        echo "<script>";
        echo "if(!confirm('세션이 만료되었거나 권한이 없습니다. 로그인 하세요!')) {
                    history.back(); 
                }  
                else {
                    location.href='https://fms.iwin.kr/login.php';                                       
                }";
        echo "</script>";
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.10.21>
    // Note: 부트스트랩 날짜선택 모듈 핸들링
    // =========================================================================  
    function CropDate($date) {
        //ex) 2021-01-08 - 2022-04-04 형태
        $StartDate = substr($date, 0, 10);		
	    $EndDate = substr($date, 13, 10);
        $StartYear = substr($date, 0, 4);		
	    $EndYear = substr($date, 13, 4);

        return array($StartDate, $EndDate, $StartYear, $EndYear);    
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.04.26>
    // Note: 데이터 수정 버튼2
    // =========================================================================  
    function ModifyData2($modify_value, $save_value, $kind){
        include '../DB/DB2.php';

        //수정독점화를 하고 저장시간 장버튼을 누르지 않아 업무 지연이 생기는것을 방지코자 5분이상 수정모드가 지속적인 경우 강제 해지하는 알고리즘
        $Query_StatusCount = "SELECT * from CONNECT.dbo.USE_CONDITION WHERE LOCK='Y'";          
        $Result_StatusCount = sqlsrv_query($connect, $Query_StatusCount);

        while ($Data_StatusCount = sqlsrv_fetch_array($Result_StatusCount, SQLSRV_FETCH_ASSOC)) {
            if (empty($Data_StatusCount['LAST_DT'])) continue; // Skip if LAST_DT is null

            $last_lock_time = $Data_StatusCount['LAST_DT'];
            $current_time = new DateTime();
            $interval = $current_time->diff($last_lock_time);
            $change_min = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

            //5분 이상 LOCK인 경우 강제 N으로 업데이트
            IF($change_min >= 5) {
                $Query_StatusChange = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='" . $Data_StatusCount['KIND'] . "'";          
                sqlsrv_query($connect, $Query_StatusChange);	
            }
        }

        $ip = $_SERVER['REMOTE_ADDR']; //사용자 IP

        $Query_ModifyCheck = "SELECT * from CONNECT.dbo.USE_CONDITION WHERE KIND='$kind'";          
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck);		
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck, SQLSRV_FETCH_ASSOC); 

        //외부에서 수정을 독점화 하는 공격을 당함 (내부ip가 삽입된 컴퓨터에서만 수정이 가능토록)
        if ($Data_ModifyCheck && $Data_ModifyCheck['LOCK']=='Y' AND $Data_ModifyCheck['WHO']==$ip) {
            echo "
                <div class='text-right' style='padding: 1em;'>                                                                
                    <button type='submit' value='on' class='btn btn-success' name='".$save_value."'><i class='fas fa-save'> 저장 및 종료</i></button>
                </div> 
            ";
        }
        ELSEIF ($Data_ModifyCheck && $Data_ModifyCheck['LOCK']=='N' and substr($ip, 0, 3)=='192') {
            echo "
                <div class='text-right' style='padding: 1em;'>                                                                
                    <a href='".$modify_value."' class='btn btn-info'><i class='fas fa-edit'> 수정</i></a>
                </div> 
            ";  	
        }        
        ELSE {
            echo "
                <div class='text-right' style='padding: 1em;'>                                                                
                    <button type='submit' value='on' class='btn btn-danger'><i class='fas fa-save'> 수정 중 (5분 이상 수정 중 일 시 클릭하세요!)</i></button>
                </div> 
            ";
        }
    }  

    // =========================================================================  
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.02.18>
    // Note: 하이폰 제거
    // =========================================================================  
    function HyphenRemove($item){
        $hyphen = strpos($item, '-');

        IF($hyphen>0) {   
            $Change_Item=str_replace('-','',$item);
        }
        else {
            $Change_Item=$item;
        }

        return strtoupper($Change_Item);
    }


    // =========================================================================  
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.02.18>
    // Note: 공장품목정보
    // =========================================================================  
    function ItemInfo($item, $option){
        //NEOE 로그인
        include '../DB/DB7.php';

        IF($option=='STND') {
            $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$item' and CD_PLANT='PL01'";          
            $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
            $Data_ItemCheck = sqlsrv_fetch_array($Result_ItemCheck);   
            
            //erp에 품번이 있지만 아래 품번은 도대체 출력이 되지가 않아 하드코딩함
            if($item=='M0051900') {
                return "W06 BACK";
            }
            elseif($item=='M0052000') {
                return "W06 CUSH";
            }
            else {
                return $Data_ItemCheck['STND_ITEM'];
            }            
        }
        elseif($option=='KIND') {
            $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$item' and CD_PLANT='PL01'";          
            $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
            $Data_ItemCheck = sqlsrv_fetch_array($Result_ItemCheck); 
            
            //24.10.31 검사 완료내역탭에서 결과카드 기타열에 카운팅되는 오류를 방지하기 위함
            if($item=='M0052000' or $item=='M0051900') {
                return "SH";
            }
            else {
                return $Data_ItemCheck['GRP_MFG'];
            } 
        }  
        elseif($option=='LOTSIZE') {
            $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$item' and CD_PLANT='PL01'";          
            $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
            $Data_ItemCheck = sqlsrv_fetch_array($Result_ItemCheck); 

            return round($Data_ItemCheck['LOTSIZE'],0);
        }   
        elseif($option=='AF') {
            $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE STND_ITEM='$item' and CD_PLANT='PL01'";          
            $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
            $Data_ItemCheck = sqlsrv_fetch_array($Result_ItemCheck);   
            
            return $Data_ItemCheck['CD_ITEM'];
        }    
    }

    // =========================================================================  
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.02.18>
    // Note: 품명출력
    // =========================================================================  
    function ItemChange($item, $option){
        //NEOE 로그인
        include '../DB/DB7.php';

        IF($option=='AF') {
            $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE STND_ITEM='$item' and CD_ITEM LIKE 'AF%'";          
            $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
            $Data_ItemCheck = sqlsrv_fetch_array($Result_ItemCheck);           
        }

        return $Data_ItemCheck['CD_ITEM'];
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.02.16>
    // Note: 현대기아차에서 추출한 품번 하이폰 생성
    // =========================================================================  
    function Hyphen($item){

        if($item!="M0052000") { 
            //품번 뒤에 (na)가 붙는 경우
            if(substr($item, -1)==')') {
                // 만약 하이펀(-)이 이미 포함되어 있다면 그대로 반환
                if(strpos($item, '-') !== false) {
                    $assembly = $item;
                } else {
                    $parts1 = substr($item, 0, 5);
                    $parts2 = substr($item, 5, 10);
                    $assembly = $parts1 . "-" . $parts2; 
            }
            }   
            else {  
                $length = strlen($item);
                
                //일반적인 10자리 품번인 경우 
                if($length==10) {
                    $parts1 = substr($item,0,5);
                    $parts2 = substr($item,5,10);
                    $assembly = $parts1."-".$parts2; 
                }
                //품번이 11자리인 경우 (S111A000110 Q201)
                elseif($length==11) {
                    $Hyphen = strpos($item, '-');
                    
                    //하이폰이 있는 경우
                    if($Hyphen>0) {
                        $assembly = $item; 
                    }
                    //하이폰이 없는 경우
                    else {
                        //88195-t2t033a 경우 88195t-2t033a로 표현이 됨
                        //시트히터의 경우 아세히 품번이 보통 8로 시작함
                        if(substr($item,0,1)==8) {
                            $parts1 = substr($item,0,5);
                            $parts2 = substr($item,5,11);
                            $assembly = $parts1."-".$parts2; 
                        }
                        else {
                            $parts1 = substr($item,0,6);
                            $parts2 = substr($item,6,11);
                            $assembly = $parts1."-".$parts2; 
                        }
                        
                    }
                }        
                else {
                    $assembly = $item;  
                }
            }
        }
        else {
            $assembly = $item; 
        }
        
        return $assembly;
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.02.15>
    // Note: 데이터 수정 버튼
    // =========================================================================  
    function ModifyData($modify_value, $save_value){
        echo "
            <div class='text-right' style='padding: 1em;'>                                                                
                <a href='".$modify_value."' class='btn btn-info'><i class='fas fa-edit'> 수정</i></a>
                <button type='submit' value='on' class='btn btn-info' name='".$save_value."'><i class='fas fa-save'> 저장</i></button>
            </div> 
        ";
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.02.04>
    // Note: 로트번호 생성
    // =========================================================================  
    function LotNumber($check, $last_num){
        if($check==0) {
            $LOT_NUM="01";
        }
        else {
            $LOT_NUM = $last_num;
    
            if(substr($LOT_NUM, 0, 1)==0) {
                if(substr($LOT_NUM, 1, 1)==9) {
                    $LOT_NUM = substr($LOT_NUM, 1, 1);
                    $LOT_NUM = $LOT_NUM + 1;
                }
                else {
                    $LOT_NUM = substr($LOT_NUM, 1, 1);
                    $LOT_NUM = $LOT_NUM + 1;
                    $LOT_NUM="0".$LOT_NUM;
                }
            }
            else {
                $LOT_NUM = $LOT_NUM + 1;
            }
        }  

        return $LOT_NUM;
    } 
    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.08.24>
    // Note: 로트번호 생성
    // =========================================================================  
    function LotNumber2($check, $last_num, $option){
        //완성품입고 수기입력
        //포장 커스텀라벨
        //ecu 커스텀라벨
        if($option=='direct') {
            //$check==0로 조건을 거닌까 수기입력이 아닌 로트번호를 잡아서 그다음 숫자부터 카운팅되는 에러가 있음
            if(substr($last_num, 0, 1)!="A" and substr($last_num, 0, 1)!="a") {
                $LOT_NUM="A01";
            }
            else {
                $LOT_NUM = $last_num;
        
                if(substr($LOT_NUM, 1, 1)==0) {
                    if(substr($LOT_NUM, 2, 1)==9) {
                        $LOT_NUM = "A10";
                    }
                    else {
                        $LOT_NUM = substr($LOT_NUM, 2, 1);
                        $LOT_NUM = $LOT_NUM + 1;
                        $LOT_NUM="A0".$LOT_NUM;
                    }
                }
                else {
                    $LOT_NUM = substr($LOT_NUM, 1, 2);
                    $LOT_NUM = $LOT_NUM + 1;
                    $LOT_NUM="A".$LOT_NUM;
                }
            }  
        }
        elseif($option=='order_label_change') {
            if($check==0) {
                $LOT_NUM="f01";
            }
            else {
                $LOT_NUM = $last_num;
        
                if(substr($LOT_NUM, 1, 1)==0) {
                    if(substr($LOT_NUM, 2, 1)==9) {
                        $LOT_NUM = "f10";
                    }
                    else {
                        $LOT_NUM = substr($LOT_NUM, 2, 1);
                        $LOT_NUM = $LOT_NUM + 1;
                        $LOT_NUM="f0".$LOT_NUM;
                    }
                }
                else {
                    $LOT_NUM = substr($LOT_NUM, 1, 2);
                    $LOT_NUM = $LOT_NUM + 1;
                    $LOT_NUM="f".$LOT_NUM;
                }
            }  
        }

        return $LOT_NUM;
    } 

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.01.27>
    // Note: 보드
    // =========================================================================  
    function BOARD($size, $color, $title, $goal, $icon){
        if($title=='금일당직' or $title=='품명') {
            echo "
                    <div class='col-xl-".$size." col-md-".$size." mb-2'>
                        <div class='card border-left-".$color." shadow h-100 py-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-".$color." text-uppercase mb-1'>".$title."</div>
                                        <div class='h5 mb-0 font-weight-bold text-gray-800'>".$goal."</div>
                                    </div>
                                    <div class='col-auto'>
                                        <i class='".$icon." fa-2x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        elseif($title=='스캔(BOX)' or $title=='품명(Tên hàng)' or $title=='스캔수량(Số lượng scan)' or $title=='목표수량(Số lượng mục tiêu)' or $title=='라벨발행수량(số lượng bản in)' or $title=='금일 마감 전 이동(PCS)' or $title=='전일 마감 후 이동(PCS)' or $title=='지입기사' or $title=='출하오더(PCS)' or $title=='출하실적(BOX)' or $title=='출하실적(PCS)') {
            echo "
                    <div class='col-xl-".$size." col-md-".$size." mb-3'>
                        <div class='card border-left-".$color." shadow h-100 py-1 px-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center h-50 py-2 px-2'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-".$color." text-uppercase mb-1'>".$title."</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>".$goal."</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='".$icon." fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }        
        elseif($title=='입고수량(BOX)' or $title=='매핑수량(BOX)') {
            echo "
                    <div class='col-xl-".$size." col-md-".$size." mb-2'>
                        <div class='card border-left-".$color." shadow h-100 py-5 px-4'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center h-100 py-5 px-1'>
                                    <div class='col mr-2'>
                                        <div class='text-lx font-weight-bold text-".$color." text-uppercase mb-1'>".$title."</div>
                                        <div class='h1 mb-0 font-weight-bold text-gray-800'>".$goal."</div>
                                    </div>
                                    <div class='col-auto px-1'>
                                        <i class='".$icon." fa-5x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";   
        }
        else {
            if($goal>=1) {
                echo "
                    <div class='col-xl-".$size." col-md-".$size." mb-2'>
                        <div class='card border-left-".$color." shadow h-100 py-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-".$color." text-uppercase mb-1'>".$title."</div>
                                        <div class='h5 mb-0 font-weight-bold text-gray-800'>".$goal."</div>
                                    </div>
                                    <div class='col-auto'>
                                        <i class='".$icon." fa-2x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";
            }
            else {             
                echo "
                    <div class='col-xl-".$size." col-md-".$size." mb-2'>
                        <div class='card border-left-".$color." shadow h-100 py-2'>
                            <div class='card-body'>
                                <div class='row no-gutters align-items-center'>
                                    <div class='col mr-2'>
                                        <div class='text-xs font-weight-bold text-".$color." text-uppercase mb-1'>".$title."</div>
                                        <div class='h5 mb-0 font-weight-bold text-gray-800'>0</div>
                                    </div>
                                    <div class='col-auto'>
                                        <i class='".$icon." fa-2x text-gray-300'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                ";                
            }
        }
    }

    // ========================================================================= 
    // Author: <KWON SUNG KUN - sealclear@naver.com> 
    // Create date: <22.01.26>
    // Note: 품번 및 기타정보 추출
    // =========================================================================  
    function CROP($barcode){

        $head = substr($barcode, 0, 1);
        $head2 = substr($barcode, 1, 1);

        //현기차 바코드 양식인 경우
        //ex) [)>06VSE22P8888888888T180824KD1SA1030000009C2.952.743.34
        //ex) [)>RS06GSVSCHIGSP88170N9510GST221205VD1SA3010000008GSC3.102.813.43GSRSEOT
        //동성르노
        //ex) [)>06VSE22P3775466T180824KD1SA1030000009C2.952.743.34
        //o)>06VSCHIP88370N9510T240201VD1SA3020000215C4.143.744.58 이런식으로 입력되어 품번과 trace code가 입력되지 않는 경우가 발생함
        if($head=='[' or $head=='o' or $head=='O') {
            $barcode_length = strlen($barcode);
            $location1 = strpos($barcode, 'P');

            //////////////////////////////////////////////품번 추출//////////////////////////////////////////////
            //품번에 t가 들어가는 경우 대비
            $temp_string = substr($barcode, $location1+11, $barcode_length-$location1-11);
            $location2 = strpos($temp_string, 'T');

            $CD_ITEM = substr($barcode, $location1+1, $location2+10);    
            $item_length = strlen($CD_ITEM);

            IF(substr($CD_ITEM, -1)=='S' OR substr($CD_ITEM, -1)=='E' OR substr($CD_ITEM, -1)=='G') {
                IF(substr($CD_ITEM, -2)=='SE' or substr($CD_ITEM, -2)=='GS') {
                    $CD_ITEM=substr($CD_ITEM, 0, $item_length-2);
                }   
                ELSE {
                    $CD_ITEM=substr($CD_ITEM, 0, $item_length-1);
                }
            }  

            //////////////////////////////////////////////추적코드 추출//////////////////////////////////////////////
            //고객사 바코드 양식 식별자(1자리), 제조일자(6자리), 부품4m/기타(5자리) -> +13자리 안에 c가 들어갈 가능성 회피
            $temp_string2 = substr($barcode, $location1+11+$location2+1, $barcode_length-$location1-11-$location2-1);
            $location3 = strpos($temp_string2, 'C'); 
            
            $TRACE_CODE= substr($barcode, $location1+11+$location2+1, $location3);
            $item_length2 = strlen($TRACE_CODE);

            IF(substr($TRACE_CODE, -1)=='M' OR substr($TRACE_CODE, -1)=='N' OR substr($TRACE_CODE, -1)=='A') { 
                IF(substr($TRACE_CODE, -2)=='MN' OR substr($TRACE_CODE, -2)=='AN' OR substr($TRACE_CODE, -2)=='AM') {
                    IF(substr($TRACE_CODE, -3)=='AMN') {            
                        $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-3);
                    } 
                    ELSE {
                        $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-2);
                    }
                } 
                ELSE {
                    $TRACE_CODE=substr($TRACE_CODE, 0, $item_length2-1);
                } 
            }

            //trace코드에 로트날짜와 로트번호가 있는데 이것을 나누지 않았음
            $LOT_DATE=substr($TRACE_CODE, 0, 6);

            //동성르노 품번이 7자리라서 문제가 생김
            //ex)824KD로 로트번호가 저장됨 (230824)
            if(substr($LOT_DATE, 4, 1)=='K') {
                //재정의
                $temp_string_dongsung = substr($barcode, $location1+8, $barcode_length-$location1-8);
                $location2_dongsung = strpos($temp_string_dongsung, 'T');
                $CD_ITEM = substr($barcode, $location1+1, $location2_dongsung+7); 
                $temp_string2_dongsung = substr($barcode, $location1+8+$location2_dongsung+1, $barcode_length-$location1-8-$location2_dongsung-1);
                $location3_dongsung = strpos($temp_string2, 'C'); 
                $TRACE_CODE= substr($barcode, $location1+8+$location2_dongsung+1, $location3_dongsung);
                $LOT_DATE=substr($TRACE_CODE, 0, 6);
            }

            //24년 3월에 구매한 zebra pda는 자동차 표준 바코드의 아스키코드값을 무시할 수가 없다.
            //펌웨어 업데이트를 하라고 하는데 유료다.... 
            //따라서 아스키값이 x박스로 나오는데 그것을 고려하여 설계한 매커니즘
            //아스키코드가 x박스로 딸려나오는걸 생각하여 아래와 같이 설계하였는데 이렇게 하면 s2012400010 q200 가 같은 차종품번은 정상적으로 출력되지 않는다.
            //if(strlen($CD_ITEM)!=10) {
            //    $CD_ITEM=substr($CD_ITEM, 0, 10);
            //}

            //세션시작
            session_start(); 

            if(substr($_SERVER['REMOTE_ADDR'], 0, 9)=='192.168.4') {
                if(strlen($CD_ITEM)<10 or substr($CD_ITEM, 8, 1)=='T') {
                    $CD_ITEM=substr($CD_ITEM, 0, 7);
                }
                else {
                    $CD_ITEM=substr($CD_ITEM, 0, 10);
                }
            }
        }
        //현기차 바코드 양식이 아닌 경우     
        else {

            $delimiter1 = strpos($barcode, '^');
            
            if($delimiter1>0) {
                //ex) 내부바코드 S^20211207^88888-88888^01^100 (ECU)
                //ex) 내부바코드 R^20211207^88888-88888^01^100 (포장라벨 자투리)
                if($delimiter1==1 or $delimiter1==2) {
                    $barcode_length = strlen($barcode);     
                    $KIND = substr($barcode, 0, $delimiter1); 
                    $delimiter2 = strpos(substr($barcode, $delimiter1+1, $barcode_length-$delimiter1), '^');
                    $LOT_DATE = strtoupper(substr($barcode, $delimiter1+1, $delimiter2));
                    $delimiter3 = strpos(substr($barcode, $delimiter1+$delimiter2+2, $barcode_length-$delimiter1-$delimiter2), '^');
                    $CD_ITEM = trim(substr($barcode, $delimiter1+$delimiter2+2, $delimiter3));
                    $delimiter4 = strpos(substr($barcode, $delimiter1+$delimiter2+$delimiter3+3, $barcode_length-$delimiter1-$delimiter2-$delimiter3), '^');
                    $LOT_NUM = substr($barcode, $delimiter1+$delimiter2+$delimiter3+3, $delimiter4);
                    $QT_GOODS = substr($barcode, $delimiter1+$delimiter2+$delimiter3+$delimiter4+4, $barcode_length-$delimiter1-$delimiter2-$delimiter3-$delimiter4);
                }
                //ex) 내부바코드 20211207^88888-88888^01^100 (공정진행표)
                else {
                    $barcode_length = strlen($barcode);                
                    $LOT_DATE = substr($barcode, 0, $delimiter1);
                    $delimiter2 = strpos(substr($barcode, $delimiter1+1, $barcode_length-$delimiter1), '^');
                    $CD_ITEM = strtoupper(substr($barcode, $delimiter1+1, $delimiter2));
                    $delimiter3 = strpos(substr($barcode, $delimiter1+$delimiter2+2, $barcode_length-$delimiter1-$delimiter2), '^');
                    $LOT_NUM = substr($barcode, $delimiter1+$delimiter2+2, $delimiter3);
                    $QT_GOODS = substr($barcode, $delimiter1+$delimiter2+$delimiter3+3, $barcode_length-$delimiter1-$delimiter2-$delimiter3);
                }
            }      
            //ex) 빌열핸들 r56185s8ab00000002204070001d00311vtn      
            elseif($head=='R') {
                $CD_ITEM = substr(strtoupper($barcode), 1, 10);
            }
            //ex) 빌열핸들 BK56185M6FA0000002111170604D00311100000000000    
            elseif($head=='B') {
                $CD_ITEM = substr(strtoupper($barcode), 2, 10);
            }
            //베트남에서 만들어오는데 라벨을 한국에서 발행하여 부착하는 유일한 차종 EX) SCHI883P5-AA5002022/05/23
            elseif($head=='S') {
                $CD_ITEM = substr(strtoupper($barcode), 4, 11);
            }
            //ERP 작업지시 번호가 들어오는 경우 EX) WMO2022080526
            elseif($head=='W' or $head=='w') {
                include '../DB/DB2.php';

                //ERP DB 작업지시 조회  
                $Query_ErpOrder = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO='$barcode'";          
                $Result_ErpOrder = sqlsrv_query($connect, $Query_ErpOrder, $params, $options);	
                $Count_ErpOrder = sqlsrv_num_rows($Result_ErpOrder);                	
                
                //작업지시를 내리고 작업지시를 삭제하는 경우가 있음
                //erp 작업지시 내리고 작업지시서 출력하고 fms 검사완료 스캔했는데 erp 작업지시를 삭제한 경우 fms에서 삭제가 불가능함을 해결하기 위한 알고리즘
                if($Count_ErpOrder>0) {        
                    $Data_ErpOrder = sqlsrv_fetch_array($Result_ErpOrder);             

                    $CD_ITEM = $Data_ErpOrder['CD_ITEM'];
                    $LOT_DATE = date("Ymd");                
                    $QT_GOODS = (int)$Data_ErpOrder['QT_ITEM'];

                    //로트번호 생성 (같은 품번의 다른번호 작업지지서가 동일한 날짜에 스캔될 수 있음)
                    $Query_CreateLotNum = "SELECT TOP 1 * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$Data_ErpOrder[CD_ITEM]' and LOT_DATE='$LOT_DATE' ORDER BY NO DESC";          
                    $Result_CreateLotNum = sqlsrv_query($connect, $Query_CreateLotNum, $params, $options);	
                    $Count_CreateLotNum = sqlsrv_num_rows($Result_CreateLotNum);	
                    $Data_CreateLotNum = sqlsrv_fetch_array($Result_CreateLotNum);  

                    if($Count_CreateLotNum==0) {
                        $LOT_NUM="01";
                    }
                    else {
                        $LOT_NUM = $Data_CreateLotNum['LOT_NUM'];
                
                        if(substr($LOT_NUM, 0, 1)==0) {
                            if(substr($LOT_NUM, 1, 1)==9) {
                                $LOT_NUM = substr($LOT_NUM, 1, 1);
                                $LOT_NUM = $LOT_NUM + 1;
                            }
                            else {
                                $LOT_NUM = substr($LOT_NUM, 1, 1);
                                $LOT_NUM = $LOT_NUM + 1;
                                $LOT_NUM="0".$LOT_NUM;
                            }
                        }
                        else {
                            $LOT_NUM = $LOT_NUM + 1;
                        }
                    } 
                }
                else {
                    $Query_ErpOrder2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE BARCODE='$barcode'";          
                    $Result_ErpOrder2 = sqlsrv_query($connect, $Query_ErpOrder2, $params, $options);	
                    $Data_ErpOrder2 = sqlsrv_fetch_array($Result_ErpOrder2);

                    $CD_ITEM = $Data_ErpOrder2['CD_ITEM'];
                    $LOT_DATE = $Data_ErpOrder2['LOT_DATE']; 
                    $LOT_NUM = $Data_ErpOrder2['LOT_NUMS'];               
                    $QT_GOODS = (int)$Data_ErpOrder2['QT_GOODS'];
                }
            }
            else {
                
                $color_code = substr($barcode, 10, 6); 

                //ex) 빌열핸들 56185g90000000002204280001sg0787111k1
                if($color_code=='000000') {
                    $CD_ITEM = substr($barcode, 0, 10);

                }
                //ex) hzg바코드 3321248   2021122200906.777.07HZG   1000   PL01   A24
                else {
                    $location1 = strpos($barcode, ' ');        
                    $CD_ITEM = substr($barcode, 0, $location1); 
                    $LOT_DATE = substr($barcode, $location1+3, 8); 
                }  
            }
        }

        return array($CD_ITEM, $TRACE_CODE, $LOT_DATE, $LOT_NUM, $QT_GOODS, $KIND, $CD_ITEM11);
    }                                         

    // =========================================================================  
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.01.25>
    // Note: 품명출력
    // =========================================================================  
    function NM_ITEM($item){
        //NEOE 로그인
        include '../DB/DB7.php';
        
        $item=TRIM($item);

        //ERP 공장품목등록 메뉴에서 아이템 존재확인
        $Query_ItemCheck = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$item' and CD_PLANT='PL01'";          
        $Result_ItemCheck = sqlsrv_query($connect, $Query_ItemCheck, $params, $options);		
        $Count_ItemCheck = sqlsrv_num_rows($Result_ItemCheck);     
        
        if($Count_ItemCheck > 0) {
            //erp에 품번이 있지만 아래 품번은 도대체 출력이 되지가 않아 하드코딩함
            if($item=='M0051900') {
                return "W06 BACK";
            }
            elseif($item=='M0052000') {
                return "W06 CUSH";
            }            
            else {
                $Query_ItemName = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$item' and CD_PLANT='PL01'";              
                $Result_ItemName = sqlsrv_query($connect, $Query_ItemName, $params, $options);		
                $Data_ItemName = sqlsrv_fetch_array($Result_ItemName);     
                
                return $Data_ItemName['NM_ITEM'];
            }
        }
        //현대기아차 바코드에서 품번을 추출할 경우 하이폰 없음
        else {
            //89370GO050(NA) 식으로 납품국가가 달라서 뒤에 ()가 붙는 경우
            if(substr($item,-1)==')') {
                if($item=='88390A7100(M)') {
                    return "YD F/BACK";
                }
                else {
                    $parts1 = substr($item,0,5);
                    $parts2 = substr($item,5,5);
                    $assembly = $parts1."-".$parts2."(";

                    $Query_ItemName = "select top 1 * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM like '$assembly%'";              
                    $Result_ItemName = sqlsrv_query($connect, $Query_ItemName, $params, $options);		
                    $Data_ItemName = sqlsrv_fetch_array($Result_ItemName);  

                    return $Data_ItemName['NM_ITEM'];
                }
            }
            else {
                $length = strlen($item);

                //일반적인 10자리 품번인 경우 
                if($length==10) {
                    $parts1 = substr($item,0,5);
                    $parts2 = substr($item,5,10);
                    $assembly = $parts1."-".$parts2;

                    $Query_ItemName = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$assembly' and CD_PLANT='PL01'";              
                    $Result_ItemName = sqlsrv_query($connect, $Query_ItemName, $params, $options);		
                    $Data_ItemName = sqlsrv_fetch_array($Result_ItemName);  

                    return $Data_ItemName['NM_ITEM'];
                }
                //품번이 11자리인 경우 (S111A000110 Q201)            
                elseif($length==11) {
                    $parts1 = substr($item,0,6);
                    $parts2 = substr($item,6,11);
                    $assembly = $parts1."-".$parts2;

                    $Query_ItemName = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$assembly' and CD_PLANT='PL01'";              
                    $Result_ItemName = sqlsrv_query($connect, $Query_ItemName, $params, $options);		
                    $Data_ItemName = sqlsrv_fetch_array($Result_ItemName);  

                    //ir warmer 인경우 하이폰이 두번 들어감
                    if($Data_ItemName['NM_ITEM']=='') {
                        $parts12 = substr($item,0,5);
                        $parts22 = substr($item,5,5);
                        $parts32 = substr($item,10,1);
                        $assembly2 = $parts12."-".$parts22."-".$parts32;

                        $Query_ItemName2 = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$assembly2' and CD_PLANT='PL01'";              
                        $Result_ItemName2 = sqlsrv_query($connect, $Query_ItemName2, $params, $options);		
                        $Data_ItemName2 = sqlsrv_fetch_array($Result_ItemName2);  

                        return $Data_ItemName2['NM_ITEM'];
                    }
                    else {
                        return $Data_ItemName['NM_ITEM'];
                    }
                }
            }
        }

    }