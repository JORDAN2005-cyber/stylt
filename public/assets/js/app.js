document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('.seg').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('.seg').forEach(b=>b.classList.remove('active'));btn.classList.add('active')}));
  document.querySelectorAll('.filter').forEach(btn=>btn.addEventListener('click',()=>{
    document.querySelectorAll('.filter').forEach(b=>b.classList.remove('active'));btn.classList.add('active');
    const f=(btn.dataset.filter||'all').toLowerCase();
    document.querySelectorAll('.reveal-item').forEach(card=>{const text=card.dataset.text||'';card.style.display=(f==='all'||text.includes(f))?'flex':'none'});
  }));
  const timeInput=document.getElementById('timeInput');
  document.querySelectorAll('.time-chip').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('.time-chip').forEach(b=>b.classList.remove('active'));btn.classList.add('active');if(timeInput)timeInput.value=btn.dataset.time}));
  const photo=document.getElementById('photoInput'), preview=document.getElementById('uploadPreview');
  if(photo&&preview) photo.addEventListener('change',()=>{const f=photo.files[0];if(!f)return;if(!f.type.startsWith('image/'))return;const r=new FileReader();r.onload=e=>{preview.innerHTML=`<img src="${e.target.result}" alt="Aperçu" style="width:100%;height:100%;object-fit:cover;border-radius:18px">`;};r.readAsDataURL(f)});
  const form=document.getElementById('bookingForm');
  if(form) form.addEventListener('submit',e=>{if(!timeInput.value){e.preventDefault();alert('Choisis une heure avant de continuer.')}});
  setTimeout(()=>document.querySelectorAll('.toast').forEach(t=>t.remove()),5000);
});
