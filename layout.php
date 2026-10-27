<?php session_start();
require __DIR__.'/data.php';
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
$role=$_SESSION['role']??'employee';
$P=$_SESSION['profile']??[];
function pv($k,$d=''){global $P;$v=$P[$k]??$d;return is_array($v)?implode(', ',$v):$v;}
function head($title,$mode='app'){global $role;$cur=basename($_SERVER['PHP_SELF']);
 $nav=$role==='employer'?['employer-home.php'=>'Dashboard','employer-search.php'=>'Search Candidates','employer-shortlist.php'=>'Shortlisted <span id="sl-count"></span>','employer-post-job.php'=>'Post a Job','notifications.php'=>'Notifications','profile.php'=>'Profile']
 :['employee-home.php'=>'Home','employee-apply.php'=>'Find Jobs','employee-applied.php'=>'Applied Jobs <span id="ap-count"></span>','employee-interviews.php'=>'Interviews','notifications.php'=>'Notifications','profile.php'=>'Profile'];
 echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).' · Easy Employment</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Merriweather:wght@700&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/style.css"></head><body'.($mode==='auth'?' class="auth"':'').'>';
 if($mode==='app'){echo '<header class="top"><div class="in"><a class="brand" href="index.php">Easy <span>Employment</span></a><nav>';
  foreach($nav as $u=>$l)echo '<a href="'.$u.'"'.($u===$cur?' class="on"':'').'>'.$l.'</a>';
  echo '</nav><a class="btn sm gold" href="signout.php">Sign out</a></div></header><main class="wrap">';}}
function foot($mode='app'){if($mode==='app')echo '</main>';
 if($mode==='app')echo "<script>try{var n=JSON.parse(localStorage.getItem('".($GLOBALS['role']==='employer'?'ee_accepted':'ee_applied')."')||'[]').length,c=document.getElementById('".($GLOBALS['role']==='employer'?'sl-count':'ap-count')."');if(c&&n){c.className='cnt';c.textContent=n}}catch(e){}</script>";
 echo '</body></html>';}
