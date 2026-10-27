<?php require 'includes/layout.php';head('Find Jobs');$_SESSION['role']='employee';?>
<h1>Find jobs</h1><p><a href="employee-apply.php">← Swipe view</a> · <a href="employee-applied.php">Applied jobs</a></p><input id="s" placeholder="Search by title, company or location" style="margin:.5rem 0 1rem">
<div class="chips"><span class="chip on" data-c="">All</span><?php foreach($categories as $c)echo '<span class="chip" data-c="'.e($c).'">'.e($c).'</span>';?></div>
<div class="card" id="list"><?php foreach($jobs as $j):?><div class="row job" data-id="<?=$j['id']?>" data-cat="<?=e($j['cat'])?>" data-t="<?=e(strtolower($j['title'].$j['co'].$j['loc']))?>"><div class="av"><?=e($j['co'][0])?></div>
<div class="grow"><b><?=e($j['title'])?></b><div class="mute"><?=e($j['co'])?> · <?=e($j['loc'])?></div><div class="mute"><?=e($j['type'])?> · <?=e($j['sal'])?></div></div><button class="btn sm apply">Apply</button></div><?php endforeach;?></div>
<script>let cat='';const rows=[...document.querySelectorAll('.job')];
function f(){rows.forEach(r=>r.style.display=(!cat||r.dataset.cat==cat)&&r.dataset.t.includes(s.value.toLowerCase())?'':'none')}
s.oninput=f;document.querySelectorAll('.chips .chip').forEach(c=>c.onclick=()=>{document.querySelectorAll('.chips .chip').forEach(x=>x.classList.remove('on'));c.classList.add('on');cat=c.dataset.c;f()});
const J=<?=json_encode($jobs)?>,ls=()=>{try{return JSON.parse(localStorage.getItem('ee_applied')||'[]')}catch(e){return[]}};
function mark(b){b.textContent='Applied ✓';b.classList.add('done')}
document.querySelectorAll('.job').forEach(r=>{const id=+r.dataset.id,b=r.querySelector('.apply');if(ls().some(x=>x.id===id))mark(b);
 b.onclick=()=>{const a=ls();if(!a.some(x=>x.id===id)){a.push(Object.assign({},J.find(j=>j.id===id),{at:new Date().toISOString()}));localStorage.setItem('ee_applied',JSON.stringify(a))}mark(b)}}) /* BACKEND HOOK: submit application */</script>
<?php foot();
