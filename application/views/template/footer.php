			</div>
		</div>

		</main>
		<footer class="footer">
			
		</footer>
	</div>
	<script src='<?=$assets?>js/time.js'></script>
	<script src='<?=$assets?>js/jquery.min.js'></script>
	<script src='<?=$assets?>js/jquery-migrate.min.js'></script>
	<script src='<?=$assets?>js/jquery-ui.min.js'></script>
	<script src='<?=$assets?>js/bootstrap.min.js'></script>
	<?php if(isset($javascript)):?><script><?=$javascript;?></script><?php endif; ?>
	<?php if(isset($js)): foreach ($js as $j):?>
	<script src='<?=$assets?>js/<?=$j?>.js'></script>
	<?php endforeach;endif;?>
	<script src='<?=$assets?>js/custom.js'></script>
</body>
</html>