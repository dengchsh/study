安装
源  列表 
	http://www.ffmpeg.org/releases/ 
下载
	wget http://www.ffmpeg.org/releases/ffmpeg-3.4.tar.gz
解压

可能问题-、
安装ffmpeg过程中，执行./configure时，报yasm/nasm not found or too old. Use --disable-yasm for a crippledbuild错误，分析、解决如下：

分析：yasm是汇编编译器，ffmpeg为了提高效率使用了汇编指令，如MMX和SSE等。所以系统中未安装yasm时，就会报上面错误。

解决：安装yasm编译器。安装方法如下：

在http://www.tortall.net/projects/yasm/releases下面找到适合自己平台的yasm版本。然后进行安装。举例如下：

1）下载：wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz

2）解压：tar zxvf yasm-1.3.0.tar.gz

3）切换路径： cd yasm-1.3.0

4）执行配置： ./configure

5）编译：make

6）安装：make install
	
	./configure
	
	make
	
	makeinstall




ffmpge  拓展安装


	https://sourceforge.net/projects/ffmpeg-php/files/ffmpeg-php/
文档

	http://char0n.github.io/ffmpeg-php/	



	
	require_once './FFmpegAutoloader.php';
	$moviePath= '/data/wwwroot/default/ffmpeg-php/test/data/test.mp4';
	$movie = new FFmpegMovie($moviePath);
	
	
	
	$ff_frame = $movie->getFrame(1);
	$gd_image = $ff_frame->toGDImage();
	
	
	// $img="./test.jpg";
	// imagejpeg($gd_image, $img);
	// imagedestroy($gd_image);
	
	
	
	
	$objzhen = new FFmpegFrame($gd_image);
	//     // echo '<pre>';
	//     //     print_r($obj->getFrame());
	//     // echo '</pre>';
	
	    echo '<pre>';
	        print_r($objzhen->getHeight());
	    echo '</pre>';

