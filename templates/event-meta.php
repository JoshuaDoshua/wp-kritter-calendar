<?php global $post; ?>

<dl class="kcal-event-meta">
	<dt>Date</dt>
	<dd><?= $post->event->date;?></dd>
	<dt>Time</dt>
	<dd><?= $post->event->time; ?></dd>
</dl>
