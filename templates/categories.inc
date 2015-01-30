<?

$all_categories = $VOTER->getVotesByCategory();

?>
<div class="col-sm-3 col-md-2" style="background-color: #707070;">
	<ul class="nav nav-sidebar">
		<? foreach ($all_categories as $cat) { ?>
			<li>
				<a href="/vote/<?=$cat['name']?>">
					<?
					if ($cat['name'] === $TEMPLATE->category) {
						printf("<b>%s</b>", $cat['name']);
					} else {
						printf("%s (%d / %d)", $cat['name'], $cat['num_votes'], $cat['num_talks']);
					}
					?>
				</a>
			</li>
		<? } ?>
	</ul>
</div>
