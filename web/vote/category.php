<?

if (preg_match('#^/vote/(?:category/)?([A-Z][A-Za-z/]+)#', $_SERVER['REQUEST_URI'], $regs)) {
	$category = $regs[1];
} else {
	$category = "PHP";
}

$talks = $VOTER->getTalksByCategory($category);

$TEMPLATE->page($category);
$TEMPLATE->body_class = "dashboard";
$TEMPLATE->category = $category;

$map_level = [
	"entry" => "Beginner",
	"mid" => "Intermediate",
	"advanced" => "Advanced",
];

$map_type = [
	"regular" => "45-min Talk",
	"tutorial" => "Tutorial",
	"focus" => "Focus Group",
];

$TEMPLATE->display("categories.inc");
?>

<div class="admin-content col-sm-9 col-md-10">
	<p>You don't need to vote in every category. Feel free to pick and choose the categories that you are most interested in.</p>
	<p>You can click on any of the talk titles to see a full description of the talk.</p>
	
	<table class="table table-hover">
		<thead>
			<tr>
				<th><h2 class="headline"><?=$category?></h2></th>
				<th>Presentation<br />Level &amp; Type</th>
				<th>Interest Level<br />(Vote Here)</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($talks as $t) { ?>
				<tr id="row-<?=$t['id']?>" <? if ($t['rating'] > 0) echo "class='voted'"; ?>>
					<td>
						<h4><a data-toggle="collapse" href="#desc-<?=$t['id']?>" aria-expanded="false" aria-controls="desc-<?=$t['id']?>">
							<?=$t['title']?>
						</a></h4>
						<div id="desc-<?=$t['id']?>" class="collapse">
							<?=nl2br($t['description'])?>
						</div>
					</td>
					<td width="150">
						<?=$map_level[$t['level']]?><br />
						<?=$map_type[$t['type']]?>
					</td>
					<td class="vote" width="150">
						<?
						for ($i = 1; $i <= 5; $i++) {
							if ($t['rating'] == $i) {
								$btn_class = "btn-success";
							} else {
								$btn_class = "";
							}
							echo "<button id='vote-{$t['id']}-$i' type='button' class='btn btn-xs $btn_class'>$i</button>\n";
						}
						?>
					</td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</div>

<style type="text/css">
td.vote { white-space: nowrap; }
tr.voted td.vote { background-color: #d0e6d0; }
</style>

<script language="javascript">
$(function() {
	$("td.vote > button").hover(function(e) {
		if (!$(this).hasClass("btn-primary")) {
			$(this).addClass("btn-info");
		}
	}, function(e) {
		$(this).removeClass("btn-info");
	});
	$("td.vote > button").click(function(e) {
		var id = $(this).attr('id');
		var tmp = id.split("-");
		var talk_id = tmp[1];
		var rating = tmp[2];
		
		$.post("/vote/rating", { 'talk_id' : talk_id, 'rating' : rating, 'hash' : "<?=$VOTER->getHash()?>" }, function(data) {
			if (data == "1") {
				for (i = 1; i <= 5; i++) {
					$("#vote-"+talk_id+"-"+i).removeClass("btn-success");
				}
				$("#"+id).addClass("btn-success").removeClass("btn-info");
				$("#row-"+talk_id).addClass("voted");
			}
		}, "json");
	});
});
</script>
