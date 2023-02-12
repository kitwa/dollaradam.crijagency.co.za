<script src="plugins/jQuery/jQuery.min.js"></script>
<script src="plugins/materialize/materialize.min.js"></script>
<script src="js/init.js"></script>



<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
      .register('sw.js')
      .then(function() {
        console.log('Service worker registered');
      });
  }
</script>
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>

<script>
  function developpement() {
    alert("Salut, Cette fonctionalite est en cours de developpement, veuillez-nous contacter pour en savair d'avantage");
  }

  function goBack() {
  window.history.back()
}
</script>

</body>

</html>