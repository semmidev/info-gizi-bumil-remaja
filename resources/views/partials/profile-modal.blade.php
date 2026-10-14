<div class="ovl" id="profile-ovl">
  <div class="dlg" role="dialog" aria-modal="true" aria-labelledby="profile-h">
    <h3 id="profile-h">Yuk, lengkapi data dirimu</h3>
    <p class="tip" style="margin-top:0">Agar info gizi yang kamu terima lebih sesuai, lengkapi dulu: <b>{{ $missing }}</b>.</p>
    <div class="dlg-b">
      <a href="{{ route('akun') }}" class="btn" style="flex:1;text-align:center;text-decoration:none">Lengkapi Sekarang</a>
      <button type="button" class="btn ghost" id="profile-later" style="flex:1">Nanti</button>
    </div>
  </div>
</div>
<script>
(function(){
  var ovl = document.getElementById('profile-ovl');
  if (!ovl) return;
  function close(){ ovl.hidden = true; }
  document.getElementById('profile-later').addEventListener('click', close);
  ovl.addEventListener('click', function(e){ if (e.target === ovl) close(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') close(); });
})();
</script>
