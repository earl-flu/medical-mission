const r=()=>({formatDate:e=>{const t=new Date(e),n=new Date;if(isNaN(t.getTime()))return"Invalid Date";if(t.toDateString()===n.toDateString()){const o={hour:"2-digit",minute:"2-digit"};return`<span style="border-left:2px solid green; display:block; padding-left:5px;">Today at ${t.toLocaleTimeString("en-US",o)}</span>`}const i={year:"numeric",month:"long",day:"numeric",hour:"2-digit",minute:"2-digit"};return t.toLocaleString("en-US",i)}});export{r as u};
