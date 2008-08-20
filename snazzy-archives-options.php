<div class="wrap" style="max-width:950px !important;">
	<h2>Snazzy Archives</h2>
				
	<div id="poststuff" style="margin-top:10px;">

	 <div id="sideblock" style="float:right;width:220px;margin-left:10px;"> 
		 <h3>Information</h3>
		 <div id="dbx-content" style="text-decoration:none;">
			 <img src="<?php echo $imgpath ?>/home.png"><a style="text-decoration:none;" href="http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives"> Snazzy Archives Home</a><br /><br />
			 <img src="<?php echo $imgpath ?>/help.png"><a style="text-decoration:none;" href="http://www.prelovac.com/vladimir/forum"> Plugin Forums</a><br /><br />
			 <img src="<?php echo $imgpath ?>/rate.png"><a style="text-decoration:none;" href="http://wordpress.org/extend/plugins/snazzy-archives/"> Rate this plugin</a><br /><br />			 
			 <img src="<?php echo $imgpath ?>/more.png"><a style="text-decoration:none;" href="http://www.prelovac.com/vladimir/wordpress-plugins"> My WordPress Plugins</a><br /><br />
			 <br />
		
			 <p align="center">
			 <img src="<?php echo $imgpath ?>/p1.png"></p>
			
			 <p> <img src="<?php echo $imgpath ?>/idea.png"><a style="text-decoration:none;" href="http://www.prelovac.com/vladimir/services"> Need a WordPress Expert?</a></p>
 		</div>
 	</div>

	 <div id="mainblock" style="width:710px">
	 
		<div class="dbx-content">
		 	<form name="SnazzyArchives" action="<?php echo $action_url ?>" method="post">
					<input type="hidden" name="submitted" value="1" /> 
					<h3>Usage</h3>		
					<p>Create a new page for your snazzy archive, and insert the code [snazzy-archive] in the editor. Load this page and enjoy the view!</p>
					<p>For more customization options please refer to <a href="http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives">Snazzy Archives Home page</a>. </p>
					<br />
					
					<h3>Show</h3>
					<p>You can choose what pages you want to show in the archives.</p>
					<input type="checkbox" name="posts"  <?php echo $posts ?>/><label for="posts"> Show Posts</label>  <br />
					<input type="checkbox" name="pages"  <?php echo $pages ?>/><label for="pages"> Show Pages</label>  <br />
					<br />
					
					<h3>Layout</h3>
					<p>Snazzy Archives currently supports two layouts, and you can buid your own.</p>
					<input type="text" name="layout" size="15" value="<?php echo $layout ?>"/><label for="layout"> Default layout (1 or 2)</label><br/>
					<br /> 					
					<img src="<?php echo $imgpath ?>/example1.jpg"> <img src="<?php echo $imgpath ?>/example2.jpg">
					<br /s>
					<p>Layout 1 uses less space and is more compact, while layout 2 shows more information.</p>
					
					<h3>Effects</h3>
					<p>Special effects modify the way your archives look. You can either select one of them or use the archives without special effects (this is default, same as setting special fx to 0).</p>
					<input type="text" name="fx" size="15" value="<?php echo $fx ?>"/><label for="width"> Special FX</label><br/>	
					<p>Currently available effects:<br><ol>
						<li><a href="http://www.prelovac.com/vladimir/archive-spec?fx=1">Carousel</a></li>
						<?php if (0) : ?>
						<li><a href="http://www.prelovac.com/vladimir/archive-spec?fx=2">jQuery space</a></li>
						<li><a href="http://www.prelovac.com/vladimir/archive-spec?fx=3">Flash space</a></li>
						<?php  endif; ?>
					</ol></p>
					<br /><br />
					
					<h3>Display</h3>			
					<p>These are tweaks to the way Snazzy archives look.</p>
					<input type="checkbox" name="mini"  <?php echo $mini ?> /><label for="mini"> Start in mini mode (collapsed archives)</label>  <br />
					<br><img src="<?php echo $layout ?>/example3.jpg"> 
					<p>Mini mode can gain you a lot of space, and the user can expand/shrink archives by clicking on the date headings. This works in full mode too!</p>
					
					<input type="checkbox" name="corners"  <?php echo $corners ?> /><label for="corners"> Round corners of images</label>  <br /><br/>	
					<p>This will apply dynamic rounding of image corners for better looking images.</p>
					
					
					<h3>Year book</h3>	
					<p>You can specify unique text to print with any year, describing it.</p>
					<img src="<?php echo $layout ?>/example4.jpg"> <p>Year book shows below the year and is useful for sharing your thoughts.</p>
					<p>Use description in the form year#description, one per line, HTML allowed. For example: <br><br>
					2007#This was a good year! I traveled a lot and met new people.<br>
					2008#Learned a lot about WordPress and I am loving it.<br>
					</p>
					
					<textarea name="years"  rows="10" cols="80"><?php echo $years ?></textarea>				<br/>	<br/>	
					
					<div class="submit"><input type="submit" name="Submit" value="Update" /></div>
			</form>
		</div>
		
		<br/><br/><h3>&nbsp;</h3>	
	 </div>

	</div>
	
<h5>WordPress plugin by <a href="http://www.prelovac.com/vladimir/">Vladimir Prelovac</a></h5>
</div>