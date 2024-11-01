<?php

/*

Plugin Name: YES! YouTube Essential Statistics

Plugin URI: http://ryosa.com

Description: Makes use of Youtube API to show off the popularity stats of any YouTube channel including number of subscribers and total video view count of all videos on the channel, directly from your website!
Using widgets, you can position this in the sidebar, header, or anywhere else you think looks sexy. You can even include the widget multiple times with different account names to show stats for however many channels you own or want to track!  Visit http://ryosa.com for examples.

Version: 1.0.0

Author: Henrik Ryosa

Author URI: http://youtube.com/voxhousestudio

*/



/*  Copyright 2010-2012 Henrik Ryosa (henrik AT voxhouse.net)


This program is free software; you can redistribute it and/or

modify it under the terms of the GNU General Public License

as published by the Free Software Foundation; either version 2

of the License, or (at your option) any later version.



This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.



You should have received a copy of the GNU General Public License

along with this program; if not, write to the Free Software

Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.



*/


class Youtube_Essential_Widget extends WP_Widget {

  function Youtube_Essential_Widget() {

    $widget_ops = array('classname' => 'youtube_essential_widget', 'description' => 'Displays the essential info about a specified YouTube Account.' );

    $this->WP_Widget('youtube_essential_widget', 'YouTube Essential Widget', $widget_ops);

  }



  function widget($args, $instance) {

    extract($args, EXTR_SKIP);

 

    echo $before_widget;

    $title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);

    $ytuser = $instance['ytuser'];

    $showicon = empty($instance['showicon']) ? '&nbsp;' : $instance['showicon'];
    
    $orient = empty($instance['orient']) ? '&nbsp;' : $instance['orient'];

    if ( empty( $ytuser ) ) { $ytuser = 'VoxHouseStudio'; };

$ytusr = $ytuser;

$xdoc = new DomDocument;

$xdoc->Load('http://gdata.youtube.com/feeds/api/users/'.$ytusr.'');

$ytstat = $xdoc->getElementsByTagName('statistics')->item(0);
$ytthumb = $xdoc->getElementsByTagName('thumbnail')->item(0);

echo '<div style="">';
	if ($instance['showicon'] == 'yes') {
		echo '<a href="http://youtube.com/'.$ytusr.'"><img src="'.$ytthumb->getAttribute("url").'" border=0 style="width: 34px; height: 34px; border: 0px;';
	if ($instance['orient'] == 'horizontal') { echo 'margin-bottom: -15px;';}
    echo '"></a>&nbsp;';
	if ($instance['orient'] == 'vertical') { echo '&nbsp;<a href="http://youtube.com/'.$ytusr.'" target=_blank style="margin-bottom: 15px; text-decoration: none;"><font face="Verdana" style="font-family: Verdana; font-size: 14px;"><b>'.$ytusr.'</b></font></a><br>'; }
	}
echo '<font face="Verdana" style="font-family: Verdana; font-size: 12px"><b>'.$ytstat->getAttribute(subscriberCount).'</b> <a href="http://youtube.com/'.$ytusr.'" style="text-decoration: none";>Subscribers</a>, <b>'.$ytstat->getAttribute(totalUploadViews).'</b> <a href="http://youtube.com/'.$ytusr.'" style="text-decoration: none";>Video Views</a></font>'; 

    //if ( !empty( $title ) ) { /*echo $before_title . $title . $after_title;*/ };

    ?>

<div style='clear:both;'></div>



<?php 



echo $after_widget;

}

  function update($new_instance, $old_instance) {

    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);

    $instance['ytuser'] = strip_tags($new_instance['ytuser']);

    $instance['showicon'] = strip_tags($new_instance['showicon']);
    
    $instance['orient'] = strip_tags($new_instance['orient']);

    return $instance;

  }

 

  function form($instance) { 

    $ytuser = strip_tags($instance['ytuser']);
    $showicon = strip_tags($instance['showicon']);
    $orient = strip_tags($instance['orient']);

?>



<p>Display Style: <select id="<?php echo $this->get_field_id('orient'); ?>" name="<?php echo $this->get_field_name('orient'); ?>">
        <?php 
  	  echo '<option value="horizontal" ';
if ( $instance['orient'] == 'horizontal' ) { echo 'selected '; }        
      echo '>';
	  echo 'Compact</option>';
 echo '<option value="vertical" ';
if ( $instance['orient'] == 'vertical' ) { echo 'selected '; }        
      echo '>';
	  echo 'Full</option>'; ?>
      </select></p>
	  <p><label for="<?php echo $this->get_field_id('ytuser'); ?>">YouTube Username: <input class="widefat" id="<?php echo $this->get_field_id('ytuser'); ?>" name="<?php echo $this->get_field_name('ytuser'); ?>" type="text" value="<?php echo attribute_escape($ytuser); ?>" /></label></p>
      <p>Show Channel Icon: <select id="<?php echo $this->get_field_id('showicon'); ?>" name="<?php echo $this->get_field_name('showicon'); ?>">
        <?php 
  	  echo '<option value="no" ';
if ( $instance['showicon'] == 'no' ) { echo 'selected '; }        
      echo '>';
	  echo 'No</option>';
 echo '<option value="yes" ';
if ( $instance['showicon'] == 'yes' ) { echo 'selected '; }        
      echo '>';
	  echo 'Yes</option>'; ?>
      </select></p>

<?php

																			}

}



// register_widget('Youtube_Essential_Widget');

add_action( 'widgets_init', create_function('', 'return register_widget("Youtube_Essential_Widget");') );



?>