<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b class="footerTimer"></b>
    </div>
    <strong><a href="#">ISS Service Request</a></strong>
</footer>

<script type="text/javascript">
	setInterval(function(){
		var now = new Date();
		$(".footerTimer").text(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
	}, 1000);
</script>