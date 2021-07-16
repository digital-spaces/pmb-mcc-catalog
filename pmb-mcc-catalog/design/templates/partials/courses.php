<span class="course-field">
  <b><?php the_field('id');?> <?php the_field('section');?> - <?php the_field('title');?></b>
</span>

<span class="course-field">
  <b class="course-hours">
    (<span>Credits: <?php the_field('credits');?></span><span class="<?php if(the_field('class_hours') == "") {echo("cde");}?>">Class Hours: <?php the_field('class_hours');?></span><span class="<?php if(the_field('lab_hours') == "") {echo("cde");}?>">Lab Hours: <?php the_field('lab_hours');?></span><span class="<?php if(the_field('clinical_hours') == "") {echo("cde");}?>">Clinical Hours: <?php the_field('clinical_hours');?></span>)
  </b>
</span>
 
<p><?php the_field('description');?></p>
