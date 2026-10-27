<?php require 'includes/layout.php';$_SESSION['role']='employee';$role='employee';head('Find Jobs');?>
<h1>Find jobs</h1><p class="mute">Swipe right (or press ✓) to apply · swipe left (or press ✕) to skip. Arrow keys also work.</p>
<div class="chips"><span class="chip on" data-c="">All</span><?php foreach($categories as $c)echo '<span class="chip" data-c="'.e($c).'">'.e($c).'</span>';?></div>
<div class="deck" id="deck"></div>
<div class="acts"><button class="round n" id="no" title="Skip">✕</button><button class="round y" id="yes" title="Apply">✓</button></div>
<p style="text-align:center"><a href="employee-applied.php">View applied jobs →</a> · <a href="employee-jobs-list.php">List view</a> · <a href="#" id="reset">Reset deck</a></p>
<script src="assets/swipe.js"></script><script>
const esc=s=>String(s).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const sw=Swipe.init({deck:'deck',items:<?=json_encode($jobs)?>,accKey:'ee_applied',rejKey:'ee_skipped_jobs',yesBtn:'yes',noBtn:'no',resetBtn:'reset',yesLabel:'APPLY',noLabel:'SKIP',
 onChange:()=>{const n=JSON.parse(localStorage.getItem('ee_applied')||'[]').length,b=document.getElementById('ap-count');if(b){b.className=n?'cnt':'';b.textContent=n||''}},
 render:j=>`<div class="av lg">${esc(j.co[0])}</div><h2>${esc(j.title)}</h2><div class="mute">${esc(j.co)}</div>
 <dl><dt>Location</dt><dd>${esc(j.loc)}</dd><dt>Type</dt><dd>${esc(j.type)} · ${esc(j.work)}</dd><dt>Salary</dt><dd>${esc(j.sal)}</dd><dt>Experience</dt><dd>${esc(j.exp)}</dd></dl>
 <p class="mute" style="margin-top:.9rem">${esc(j.desc)}</p><div class="chips">${j.skills.map(s=>'<span class="chip on">'+esc(s)+'</span>').join('')}</div>`});
sw.draw();
document.querySelectorAll('.chips .chip').forEach(x=>x.onclick=()=>{document.querySelectorAll('.chips .chip').forEach(y=>y.classList.remove('on'));x.classList.add('on');const c=x.dataset.c;sw.filter(j=>!c||j.cat===c)});</script>
<?php foot();
