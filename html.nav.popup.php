<?php if (isMobile()) { ?>
<div id="nav-popup" style="background-color:#FFFFFF; display:none;" data-visible="1" class="navmenu jump-window-mode jump-flotant-nav jump-flotant-heightfill jump-flotant-heightfill-top jump-scroll nav-level-1 col col-nav col-xs-12 col-sm-12 col-md-3 col-lg-3">
	<div id="nav-popup-head" class="nav-popup-element">
	</div>
	<div id="nav-popup-filter" class="nav-popup-element">
		<?php include("./popup.advanced-search-mobile.php"); ?>
	</div>
	<div id="nav-popup-layers" class="nav-popup-element">
	</div>
	<div id="nav-popup-content" class="nav-popup-element">
	</div>
</div>
<?php } ?>