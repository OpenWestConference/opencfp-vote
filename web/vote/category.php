<?

if (preg_match('#^/vote/category/([A-Z][A-Za-z/]+)#', $_SERVER['REQUEST_URI'], $regs)) {
	$category = $regs[1];
} else {
	$category = "PHP";
}

$talks = $VOTER->getTalksByCategory($category);

$TEMPLATE->page($category);
$TEMPLATE->body_class = "dashboard";
$TEMPLATE->category = $category;

$TEMPLATE->display("categories.inc");
?>
<div class="admin-content col-sm-9 col-md-10">
	<h2 class="headline"><?=$category?></h2>
	
	<? foreach ($talks as $t) { ?>
		<div class="talk">
			<h4><?=htmlentities($t['title'])?></h4>
		</div>
	<? } ?>
</div>
