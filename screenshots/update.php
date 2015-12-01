<?php




/*switch ($_REQUEST['request']) {
	case 'update_serials':*/
	mysql_query("TRUNCATE TABLE update_serials")or die(mysql_error());
		//mysql_query("ALTER TABLE id SET AUTO_INCREMENT=1")or die(mysql_error());
mysql_query("SET NAMES utf8") or die(mysql_error());
		for($i=1;$i<=1;$i++){  //59 oae eae ia iiiaio iaienaiey ne?eioa eo 59
			//$pagen = "http://nowfilms.ru/serial/";
			//$pagen = "http://nowfilms.ru/serial/";
			//$page = file_get_contents($pagen);  //iieo?aai oaee ia ea?aie no?aieoa

//				$url = "http://kinokong.net/serial/";
				$url = "http://kinokong.net/serial/";
//				$url = "http://kinokong.net/dokumentalnyy/page/16/";



				$ch = curl_init();  
				curl_setopt($ch, CURLOPT_URL, $url); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
				$page = curl_exec($ch); 
				//print_r($result);
				curl_close($ch);

				$z1=1;
				$z2="a".$z1."b";
				echo $z2;

			//echo $page;

//			$e = explode('<span class="new_movie7">', $page);  //Ia?acaai ai nnueie
			
			$e = explode('<span class="main-sliders-bg">', $page);  //Блоки сериалов
			$dd = count($e);  //колличество сериалов на старнице
			//print_r($e);
			
//			echo $dd;
				for($tt=1;$tt<=$dd;$tt++){ 

//
					$d = explode('<span class="main-sliders-bg"><a href="', $e[$tt]); //ссылка на старницу сериала
//					echo $d;
					$f = explode('"', $d[1]); // ia?acaai ai naiie nnueee
					$ddd = trim($f[0]);
					$name = iconv('windows-1251','utf-8',$e[$tt]);
//					$name = explode('<span class="new_movinfo1">', $name);
					$name = explode('<div class="main-sliders-title">', $name);

//                    echo $name;
					


//					$name = explode("(", $name[1]);
  				    $name = explode("</a>", $name[1]);



					$name = $name[0];


					$ddd =  explode('<a href="', $name);
					$ddd =  explode("\">", $ddd[1]);
					$ddd = $ddd[0];					

//					echo $name;

//					$name1 = substr($name,1,100);
					$name1 =explode('">', $name);
					$name = $name1[1];

                    $name =str_replace('смотреть онлайн','',$name);
                    $name =str_replace('Все серии','',$name);
                    $name =str_replace('Смотреть онлайн','',$name);
                    $name =str_replace('все серии','',$name);

                    $name =str_replace('(2001)','',$name);
					$name =str_replace('(2002)','',$name);
                    $name =str_replace('(2003)','',$name);
					$name =str_replace('(2004)','',$name);
                    $name =str_replace('(2005)','',$name);
					$name =str_replace('(2006)','',$name);
                    $name =str_replace('(2007)','',$name);
					$name =str_replace('(2008)','',$name);
                    $name =str_replace('(2009)','',$name);
					$name =str_replace('(2010)','',$name);
                    $name =str_replace('(2010)','',$name);
					$name =str_replace('(2011)','',$name);
                    $name =str_replace('(2012)','',$name);
					$name =str_replace('(2013)','',$name);
                    $name =str_replace('(2014)','',$name);
					$name =str_replace('(2015)','',$name);




					if($ddd != ''){
						$query = mysql_query("SELECT id FROM serials WHERE name = '$name'");
						$result = mysql_fetch_assoc($query);
						$id = $result['id'];
						$query = mysql_query("SELECT * FROM serials WHERE name='$name'");
						$res = mysql_fetch_assoc($query);
						if(empty($res)){
							mysql_query("INSERT INTO `serials`(`url`,`name`) VALUES('$ddd','$name')")or die(mysql_error());
							$query = mysql_query("SELECT id FROM serials WHERE name='$name'");
							$res = mysql_fetch_assoc($query);
							$id = $res['id'];
						//	echo $name."<br>";
							mysql_query("INSERT INTO `update_serials`(`file_url`,`name`,`serial_id`) VALUES('$ddd','$name','$id')")or die(mysql_error());
						}else{
							//echo $name."<br>";
							mysql_query("INSERT INTO `update_serials`(`file_url`,`name`,`serial_id`) VALUES('$ddd','$name','$id')")or die(mysql_error());
					}
				}



				
			}
		}



	mysql_query("TRUNCATE TABLE about")or die(mysql_error());
$res = mysql_query("SELECT * FROM update_serials ")or die(mysql_error());
		while ($ser = mysql_fetch_assoc($res)) {
				$ser_url = $ser["file_url"];
			$name = $ser['name'];
			$ser_id = $ser['serial_id'];

			echo '<br/>';
			echo $name;
			echo '<br/>';
			echo $ser_id;
			echo '<br/>';

			
				$ch = curl_init();  
				curl_setopt($ch, CURLOPT_URL, $ser_url); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
				$page = curl_exec($ch); 
				curl_close($ch);





           // режем описание
			$rese=iconv('windows-1251','utf-8',$page);
			$about = explode('<div class="full-kino-story disable_select">', $rese);
//			$about = explode('<br />',$about[1]);
			$about = explode('<!-- /RIGHT -->',$about[1]);
			$about = strip_tags($about[0]);


           // режем картинку
			$a1 = explode('<div class="full-poster">', $rese);
			$a2 = explode('<img src="', $a1[1]);
			$a3 = explode('" ',$a2[1]);

            if (strpos($a3[0],":")== FALSE) {
			$a4 = "http://kinokong.net".$a3[0];
			} else{
            $a4  = $a3[0];
			}
             $img= $a4;

           // режем данные 


    $rese = explode('<div class="full-kino-info">',$rese);
    $rese = $rese[1]; 


	if(strpos($rese, 'Продолжительность:') === false){

	}else{
		$time = explode("Продолжительность: ", $rese);
		$time = explode(" мин", $time[1]);
	}
	if(strpos($rese, 'Время:') === false){

	}else{
		$time = explode("Время:", $rese);
		if(strpos($time[1], ' мин') === false){
		$time = explode(" мин", $time[1]);
		}else{
		$time = explode("</b>", $time[1]);}
	}
	if(strpos($time[0], '~') === false){

	}else{
		$time[0] = '';
	}

    $time = strip_tags($time[0]);
	if (strlen($time)>10){
	$time = substr ($time,0,10);}


	$year = explode('-20', $ser_url);
	$year = explode("-", $year[1]);
	$year = '20'.$year[0];
	$year = str_replace('.html','',$year);
	//echo $year."<br>";
	

	if(strpos($rese, 'Жанр:') === false){

	}else{
		$janr = explode("Жанр:", $rese);
		$janr = explode("</b>", $janr[1]);
	}

    $janr = strip_tags($janr[0]);

	//echo $about."<br>";
	//echo "<img src='$img' /><br>";
	//echo $time."<br>";
	//echo $about;
	 
	//$name = strip_tags($name);
	//echo $time;
	echo "INSERT INTO `about`(`serial_id`,`name`,`url`,`about`,`img`,`ser_count`,`time`,`year`,`janr`) VALUES('$ser_id','$name','$ser_url','$about','$img','1','$time','$year','$janr')"."<br>";
//	mysql_query("INSERT INTO `about`(`serial_id`,`name`,`url`,`about`,`img`,`ser_count`) VALUES('$ser_id','$name','$ser_url','$about','$img','1')");
	mysql_query("INSERT INTO `about`(`serial_id`,`name`,`url`,`about`,`img`,`ser_count`,`time`,`year`,`janr`) VALUES('$ser_id','$name','$ser_url','$about','$img','1','$time','$year','$janr')");
	//echo "Добавил <b style='color:red'>$name</b>"."<br>";
}

/********************************/
/* Обновление сероий у сериалов */

/********************************/

mysql_query("SET NAMES utf8") or die(mysql_error());
		mysql_query("TRUNCATE TABLE update_series")or die(mysql_error());
		$res = mysql_query("SELECT serial_id,file_url,name FROM update_serials")or die(mysql_error());
		while ($ser = mysql_fetch_assoc($res)) {
			//$d = explode('<a href="', $e[$tt]); //Ia?acaai au? iaiuoa
			//$f = explode('"', $d[1]); // ia?acaai ai naiie nnueee
			//$ddd = trim($f[0]);
				//if($ddd != ''){
					$ser_url = $ser["file_url"];
					$name = trim($ser['name']);
					$ser_id = $ser['serial_id'];



					//$page = file_get_contents($ser_url);
					$ch = curl_init();  
					curl_setopt($ch, CURLOPT_URL, $ser_url); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
					$page = curl_exec($ch);					
					curl_close($ch);					

					$r = explode(',pl:"', $page);
					$e = explode('"', $r[1]);
						if($e[0] == ''){
							$r = explode(';pl=', $page);
							$e = explode('"', $r[1]);
						}
					$pl = $e[0];
					if($pl != ''){



						$ch = curl_init();  
						curl_setopt($ch, CURLOPT_URL, $pl); 
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
						curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
						$page = curl_exec($ch); 						
						curl_close($ch);



						if(substr($page, 0, 3) == pack("CCC", 0xEF, 0xBB, 0xBF)) {
   					
							$page = substr($page, 3);
							} 
							else
								{
   					
								}{
							$array = json_decode ($page);


    							if(!empty($array->playlist)){
									foreach($array->playlist as $serials){							
										$season = explode("<b>", $serials->comment);
										$season = explode(" ", $season[1]);
										$season = $season[0];
										if($serials->file == ''){
											foreach ($serials->playlist as $ser) {
												$file = $ser->file;
												$file =  explode(",", $file);
                            					$file = $file[0];	

                                                if (strpos($ser->comment,"<b>")=== false) {  
 												 $ser = explode("<br>", $ser->comment);
												  } else {
												 $ser = explode("<b>", $ser->comment);}

											/*	  echo('name: ');
                                                  echo($name);
												  echo('<br>');
												  echo('0: ');
												  echo($ser[0]);
												  echo('<br>');
												  echo('1: ');
												  echo($ser[1]);
												  echo('<br>'); */

                                                  // если перепутаны местами серии и сезоны
												 if (strpos($ser[0],'ерия')=== false) { 
//												 if (strpos($ser[0],iconv('utf-8','windows-1251','ерия'))=== false) { 
/*                                                  echo('выбрано: ');
												  echo($ser[1]);
												  echo('<br>');  */
 												 $ser = explode(" ", $ser[1]);
 												  } else {
  /*                                                echo('выбрано: ');
												  echo($ser[1]);
												  echo('<br>'); */
 												 $ser = explode(" ", $ser[0]);}
 												 $ser = $ser[0];

												if(strpos($file, "Serial.Nowfilms") === false ){
												mysql_query("INSERT INTO `update_series`(`serial_id`,`season`,`name`,`url`,`num`) VALUES('$ser_id','$season', concat('$name',' ',season,' сезон'),'$file','$ser')") or die(mysql_error());
												}
											}
										}else{

											$file = $serials->file;
											$file =  explode(",", $file);
                            				$file = $file[0];

                                               if (strpos($serials->comment,"<b>")=== false) {  
												 $ser = explode("<br>", $serials->comment);
												  } else {
												 $ser = explode("<b>", $serials->comment);}

//											$ser = explode("<b>", $serials->comment);
											$ser = explode(" ", $ser[0]);
											$ser = $ser[0];



											if(strpos($file, "Serial.Nowfilms") === false ){
												mysql_query("INSERT INTO `update_series`(`serial_id`,`name`,`url`,`num`,`season`) VALUES('$ser_id', concat('$name',''),'$file','$ser','1')") or die(mysql_error());

											}
										}
									}
								}
						} 
					}
				//}
		}
	/*break;
	case 'ser_count':
		mysql_query("SELECT MAX ");
	break;
	case 'update_seasons':*/

/********************************/
/* Обновление СТАЛКЕРА          */

/********************************/

mysql_query("SET NAMES utf8") or die(mysql_error());
		$query = mysql_query("SELECT * FROM update_serials");
		while ($res = mysql_fetch_assoc($query)) {
			$file_url = $res['file_url'];
			$name = trim($res['name']);
			$serial_id = $res['serial_id'];

/*    РАНЬШЕ ДОП ЗАКАЧКА КАРТИНОК СЕЙЧАС НЕНАДО 			
			//$page = file_get_contents($file_url);
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $file_url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
			$page = curl_exec($ch); 

			$rese=iconv('windows-1251','utf-8',$page);
			$img = explode('<!--TBegin--><a href="', $rese);
			$img = explode('" onclick', $img[1]);
			$img = $img[0];


			$a1 = explode('<div class="full2">', $rese);
			$a2 = explode('<img src="', $a1[1]);
			$a3 = explode('" style=',$a2[1]);
			$a4 = "http://nowfilms.ru".$a3[0];
			$img = $a4;

*/		

			$query2= mysql_query("SELECT s.serial_id as serial_id, ser.name as name, img ,a.about as about, ser.season as season, max(ser.num) as num,'' as sercount,file_url, ser.season, `year`,`time`
from  update_series ser  left join about a on (a.serial_id=ser.serial_id ) , update_serials s  where   s.serial_id= '$serial_id' and ser.serial_id = '$serial_id' group by  serial_id, ser.name ,ser.season")or die(mysql_error());
			while($res2 = mysql_fetch_assoc($query2)){
				$about = strip_tags(  $res2['about']);
				$id_ser =strip_tags(  $res2['serial_id']);
				$name = strip_tags( trim($res2['name']));
				//echo $name."<br>";
				$img = strip_tags( $res2['img']);
				$year = strip_tags( $res2['year']);
                $time = strip_tags( $res2['time']);



				$season = strip_tags( $res2['season']);
				$num = strip_tags( $res2['num']);
				$sercount = strip_tags( $res2['sercount']);
				$file_url =strip_tags(  $res2['file_url']);
				$i = 0;
				$serieses='';
				
				while($i<=$num){
					$serieses.='i:'.$i.';';
					if($i==0 or $i == $num){}else{
						$serieses.='i:'.$i.';';
					}
					$i++;
				}
				$i -=1;
				$serieses="a:$i:{".$serieses.'}';
				$e++;
				/*$file_url="http://86.57.251.22/game.php?action=serial_url&season=$id_ser&number=";
				mysql_query("INSERT INTO update_seasons(id,serial_id,name,about,img,season,serial_in_season,sercount,file_url) VALUES('$e','$id_ser','$name','$about','$img','$season','$num','$serieses','$file_url')") or die(mysql_error());
				$query4= mysql_query("SELECT * FROM update_seasons WHERE name = '$name'") or die(mysql_error());
				$res4 = mysql_fetch_assoc($query4);*/
				$query5 = mysql_query("SELECT id,series,name FROM stalker_db.video WHERE name = '$name'") or die(mysql_error());
				$res5 = mysql_fetch_assoc($query5);
				//$name = trim($res4['name']);
				if(empty($res5)){

                    /******************************************/
					/*       ДОБАВЛЯЕМ НОВЫЙ СЕРИАЛ !!!!      */
					/******************************************/

					/*$about = $res4['about'];
					$img = $res4['img'];
					$serial_in_season = $res4['serial_in_season'];
					$season = $res4['season'];
					$sercount = $res4['sercount'];
					$file_url = $res4['file_url'];*/
					mysql_query("INSERT INTO stalker_db.video (owner, name , old_name,   o_name, fname, description, pic, cost,time, file,path, protocol,rtsp_url, censored, hd,series, volume_correction, category_id,genre_id, genre_id_1, genre_id_2, genre_id_3, genre_id_4, cat_genre_id_1, cat_genre_id_2, cat_genre_id_3, cat_genre_id_4,director,actors,year, accessed, status, disable_for_hd_devices, added, count, count_first_0_5, count_second_0_5, vote_sound_good, vote_sound_bad, vote_video_good, vote_video_bad, rate, last_rate_update, last_played, for_sd_stb, kinopoisk_id, rating_kinopoisk, rating_count_kinopoisk, rating_imdb, rating_count_imdb,    rating_last_update )
VALUES( '', '$name','','','','$about','$img',0,'','',concat(id,'_season_nowfilms_','$id_ser'), 'custom','$file_url',0,0,'$serieses',0,15,0,0,0,0,0,0,0,0,0,'','','',1,1,0, now(),0,0,0,0,0,0,0,'',null,null,0,0,0,0,0,0, '0000-00-00 00:00:00')")or die(mysql_error());

					$id_seas = mysql_insert_id();
					$qer = mysql_query("SELECT id FROM stalker_db.video WHERE name='$name'") or die(mysql_error());
					$res6 = mysql_fetch_assoc($qer);
					$id_season = $res6['id'];
					$row = "http://86.57.251.22/game.php?action=serial_url&season=$id_season&number=";
					mysql_query("UPDATE stalker_db.video SET rtsp_url = '$row' WHERE name = '$name'");
					$query7 = mysql_query("SELECT id FROM stalker_db.video WHERE name='$name'");
					$res7 =mysql_fetch_assoc($query7);
					$id = $res7['id'];
					$name = trim($name);
                    /******************************************/
					/*       ЗАГОНЯЕМ УРЛЫ НА СЕРИИ      */
					/******************************************/
					$query8 = mysql_query("SELECT * FROM update_series WHERE name like '%$name%'");
					while($res8 = mysql_fetch_assoc($query8)){
						$url = $res8['url'];
						$num = $res8['num'];
						mysql_query("INSERT INTO newitvby.game_series(`url`,`Season_ID`,`seria`) VALUES('$url','$id','$num')") or die(mysql_error());
					}

                    /******************************************/
					/*       КАРТИНКИ................         */
					/******************************************/

					mysql_query("INSERT INTO stalker_db.screenshots(name,size,type,media_id) values('$img','0','image/jpeg','$id')") or die(mysql_error());
					$query11 = mysql_query("SELECT * FROM stalker_db.screenshots WHERE media_id = '$id'") or die(mysql_error());
					$res11=mysql_fetch_assoc($query11);
					$ch = curl_init($res11['name']); /*ссылка на картинку*/
					$id = $res11['id']; 
					$fp = fopen("./images/$id.jpg", 'wb'); 


					$uagent = "Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.9.181 Version/12.00";
					curl_setopt($ch, CURLOPT_USERAGENT, $uagent);

					curl_setopt($ch, CURLOPT_FILE, $fp); 
					curl_setopt($ch, CURLOPT_HEADER, 0); 					
					curl_setopt ( $ch , CURLOPT_REFERER , 'http://kinokong.net/serial/' );
					curl_exec($ch); 
					curl_close($ch); 
					fclose($fp); 
					if ($handle = opendir('./images')) {
    					while (false !== ($file = readdir($handle))) { 
        					if ($file != "." && $file != "..") { 

            					$files = explode(".", $file);

           						$filee = ceil($files[0]/100);
            					$img = $files[0];

           						$dir = "./images";
            					if(file_exists("./$filee") === true){
            					//rename($handle."/$img", "")
            						rename($dir."/$file", "./$filee/".$file);
            					}else{
            						mkdir("./$filee");
            						rename($dir."/$file", "./$filee/".$file);
           						}
           					}
        				} 
    				}
    				closedir($handle); 
				
			
				echo "Добавил <d style='color:red'>$name</d><br>";
			//	echo $name."<br>";

			}
                    /******************************************/
					/*       ОБНОВЛЯЕМ СУЩЕСТВУЮЩИЙ СЕРИАЛ !!!!      */
					/******************************************/					
			
			elseif($serieses != $res5['series'] && $name == $res5['name']){
				
				mysql_query("UPDATE stalker_db.video SET series = '$serieses', added = now() WHERE name = '$name'");
				$query8 = mysql_query("SELECT id FROM stalker_db.video WHERE name = '$name'");
				$res8 = mysql_query($query8);
				$id = $res8['id'];
				$sercount  = explode(':',$sercount);
				$sercount  = explode(":", $sercount[1]);
				$sercount =$sercount[0];  
				$query2 = mysql_query("SELECT * FROM newitvby.game_series WHERE Season_ID='$id'");
				for($i=0;$i<=$sercount;$i++){
					$res2 = mysql_fetch_assoc($query2);
					if(empty($res2)){
						$query7 = mysql_query("SELECT id FROM stalker_db.video WHERE name='$name'");
						$res7 =mysql_fetch_assoc($query7);
						$id = $res7['id'];
						$query8 = mysql_query("SELECT * FROM update_series WHERE  name like '%$name%'");
						while($res8 = mysql_fetch_assoc($query8)){
							$url = $res8['url'];
							$num = $res8['num'];
							$query21 = mysql_query("SELECT MAX(seria),Season_ID from newitvby.game_series WHERE Season_ID='$id'");
							$res21 = mysql_fetch_assoc($query21);
								$iidd = $res21['Season_ID'];
								$sseerr = $res21['seria'];
								if($id == $iidd &&  $num>$sseerr){
									mysql_query("INSERT INTO newitvby.game_series(url,Season_ID,seria) VALUES('$url','$id','$num')");
								}
						}
					}
				}
				echo "Обновил <d style='color:red'>$name</d><br>";
			}else{

				//mysql_query("UPDATE stalker_db.video SET pic = '$img' WHERE name = '$name'");

			}
			}
		}
	/*break;
	case 'end_ser':
		$query = mysql_query("SELECT * FROM update_seasons");
		while ($res = mysql_fetch_assoc($query)) {
			$serial_id = $res['id'];
			$ser_count = $res['ser_count'];
			$query2 = mysql_query("SELECT ser_count FROM seasons WHERE id='$id'") or die(mysql_error());
			if(!empty($query2)){
				$res2 = mysql_fetch_assoc($query2);
				$ser_count2 = $res2['ser_count'];
				if($ser_count != $ser_count2){
					mysql_query("UPDATE seasons SET ser_count = '$ser_count'");
					mysql_query("DELETE * FROM series WHERE serial_id='$id'");
					$query3 = mysql_query("SELECT * FROM update_series WHERE serial_id='$id'");
					while($res3 = mysql_fetch_assoc($query3)){
						$serial_id = $res['serial_id'];
						$url = $res['url'];
						$num = $res['num'];
						mysql_query("INSERT INTO series(serial_id,url,num) VALUES('$serial_id','$url','$num')") or die(mysql_error());
					}
				} 
			}else{
				mysql_query("INSERT INTO seasons() VALUES()");

			}
		}
	break;
	case 'end_img':
		$query = mysql_query("SELECT season_id,img FROM update_seasons");
		while($res = mysql_fetch_assoc($query)){
			$season_id = $res['season_id'];
			$img = $res['img'];
			mysql_query("INSERT INTO screenshot(name,size,type,media_id) values('$img','0','image/jpeg','$season_id')") or die(mysql_error());
			$query2 = mysql_query("SELECT * FROM screenshot WHERE media_id = '$season_id'") or die(mysql_error());
			if(!empty($query2)){
				while ($res2 = mysql_fetch_assoc($query2)) {
					$id = $res2['id'];
					$ch = curl_init($res2['name']);
					$fp = fopen("./images/$id.jpg", 'wb');
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					if ($handle = opendir('./images')) {
    					while (false !== ($file = readdir($handle))) { 
        					if ($file != "." && $file != "..") { 
           						//echo "$file\n"; 
            					$files = explode(".", $file);
            					//echo $file[0]."<br>";
           						$filee = ceil($files[0]/100);
            					$img = $files[0];
            					//echo $file."<br>";
           						$dir = "./images";
            					if(file_exists("./$filee") === true){
            					//rename($handle."/$img", "")
            						rename($dir."/$file", "./$filee/".$file);
            					}else{
            						mkdir("./$filee");
            						rename($dir."/$file", "./$filee/".$file);
           						}
           					}
        				} 
    				}
    				closedir($handle); 
				}
			}
		}
		
	break;
	case 'add_season':

	break;
}*/


