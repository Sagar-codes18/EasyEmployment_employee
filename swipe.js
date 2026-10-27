/* Generic swipe deck. Swipe.init({deck, items, accKey, rejKey, render(item)->html, filter(item)->bool}) */
const Swipe={init(o){const ls={get:k=>{try{return JSON.parse(localStorage.getItem(k)||'[]')}catch(e){return[]}},put:(k,v)=>{try{localStorage.setItem(k,JSON.stringify(v))}catch(e){}}}; // BACKEND HOOK: persist decisions
 const deck=document.getElementById(o.deck);let flt=()=>true;
 function draw(){deck.innerHTML='<div class="empty"><div><h2>No more items</h2><p>Try another category or reset the deck.</p></div></div>';
  const done=[...ls.get(o.accKey).map(x=>x.id),...ls.get(o.rejKey)],list=o.items.filter(c=>!done.includes(c.id)&&flt(c));
  list.slice().reverse().forEach((c,i,a)=>{const d=a.length-1-i,el=document.createElement('div');el.className='sc fade';
   if(d>2)el.style.display='none';el.style.transform='scale('+(1-d*.05)+') translateY('+d*14+'px)';
   el.innerHTML='<span class="stamp y">'+(o.yesLabel||'ACCEPT')+'</span><span class="stamp n">'+(o.noLabel||'SKIP')+'</span>'+o.render(c);deck.appendChild(el);if(d===0)bind(el,c)})}
 function decide(el,c,dir){el.classList.remove('drag');el.style.transform='translate('+dir*innerWidth+'px,-40px) rotate('+dir*30+'deg)';el.style.opacity=0;
  if(dir>0){const a=ls.get(o.accKey);a.push(Object.assign({},c,{at:new Date().toISOString()}));ls.put(o.accKey,a)}else{const r=ls.get(o.rejKey);r.push(c.id);ls.put(o.rejKey,r)}
  setTimeout(()=>{draw();o.onChange&&o.onChange()},320)}
 function bind(el,c){let sx=0,dx=0,on=false;const y=el.querySelector('.y'),n=el.querySelector('.n');
  el.onpointerdown=e=>{on=true;sx=e.clientX;el.classList.add('drag');el.setPointerCapture(e.pointerId)};
  el.onpointermove=e=>{if(!on)return;dx=e.clientX-sx;el.style.transform='translate('+dx+'px,'+(-Math.abs(dx)*.05)+'px) rotate('+dx/18+'deg)';y.style.opacity=Math.max(0,dx/120);n.style.opacity=Math.max(0,-dx/120)};
  el.onpointerup=()=>{if(!on)return;on=false;if(Math.abs(dx)>110)decide(el,c,dx>0?1:-1);else{el.classList.remove('drag');el.style.transform='';y.style.opacity=n.style.opacity=0}dx=0};
  el._d=dir=>decide(el,c,dir)}
 const act=dir=>{const t=[...deck.querySelectorAll('.sc')].pop();t&&t._d&&t._d(dir)};
 document.getElementById(o.yesBtn).onclick=()=>act(1);document.getElementById(o.noBtn).onclick=()=>act(-1);
 document.addEventListener('keydown',e=>{if(e.key==='ArrowRight')act(1);if(e.key==='ArrowLeft')act(-1)});
 document.getElementById(o.resetBtn).onclick=e=>{e.preventDefault();ls.put(o.accKey,[]);ls.put(o.rejKey,[]);draw();o.onChange&&o.onChange()};
 return{filter(f){flt=f;draw()},draw}}};
