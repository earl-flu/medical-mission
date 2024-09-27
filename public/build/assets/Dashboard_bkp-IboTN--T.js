import{z as I,A,B as q,C as T,k as D,l as U,D as V,m as $,E as O,G as z,H as L,T as G,f as H,a as x,u as m,w as B,F as W,o as K,Z as R,b as s,e as Q,n as Z,t as F}from"./app-CmUxgkoC.js";import{_ as J}from"./AuthenticatedLayout-7q1i4CHE.js";import{_ as X}from"./TextInput-8Iu5yxWU.js";import{C as k,e as Y,P as tt,p as et,a as at,A as st,b as ot,B as rt,c as nt,L as lt,d as it}from"./chartjs-plugin-datalabels.esm-NcYaoPnb.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const j={data:{type:Object,required:!0},options:{type:Object,default:()=>({})},plugins:{type:Array,default:()=>[]},datasetIdKey:{type:String,default:"label"},updateMode:{type:String,default:void 0}},dt={ariaLabel:{type:String},ariaDescribedby:{type:String}},ct={type:{type:String,required:!0},...j,...dt},ut=T[0]==="2"?(t,r)=>Object.assign(t,{attrs:r}):(t,r)=>Object.assign(t,r);function C(t){return L(t)?O(t):t}function pt(t){let r=arguments.length>1&&arguments[1]!==void 0?arguments[1]:t;return L(r)?new Proxy(t,{}):t}function gt(t,r){const n=t.options;n&&r&&Object.assign(n,r)}function M(t,r){t.labels=r}function N(t,r,n){const g=[];t.datasets=r.map(d=>{const i=t.datasets.find(f=>f[n]===d[n]);return!i||!d.data||g.includes(i)?{...d}:(g.push(i),Object.assign(i,d),i)})}function mt(t,r){const n={labels:[],datasets:[]};return M(n,t.labels),N(n,t.datasets,r),n}const ft=I({props:ct,setup(t,r){let{expose:n,slots:g}=r;const d=D(null),i=A(null);n({chart:i});const f=()=>{if(!d.value)return;const{type:c,data:u,options:_,plugins:b,datasetIdKey:w}=t,v=mt(u,w),o=pt(v,u);i.value=new k(d.value,{type:c,data:o,options:{..._},plugins:b})},h=()=>{const c=O(i.value);c&&(c.destroy(),i.value=null)},y=c=>{c.update(t.updateMode)};return U(f),V(h),$([()=>t.options,()=>t.data],(c,u)=>{let[_,b]=c,[w,v]=u;const o=O(i.value);if(!o)return;let e=!1;if(_){const a=C(_),l=C(w);a&&a!==l&&(gt(o,a),e=!0)}if(b){const a=C(b.labels),l=C(v.labels),p=C(b.datasets),P=C(v.datasets);a!==l&&(M(o.config.data,a),e=!0),p&&p!==P&&(N(o.config.data,p,t.datasetIdKey),e=!0)}e&&z(()=>{y(o)})},{deep:!0}),()=>q("canvas",{role:"img",ariaLabel:t.ariaLabel,ariaDescribedby:t.ariaDescribedby,ref:d},[q("p",{},[g.default?g.default():""])])}});function E(t,r){return k.register(r),I({props:j,setup(n,g){let{expose:d}=g;const i=A(null),f=h=>{i.value=h==null?void 0:h.chart};return d({chart:i}),()=>q(ft,ut({ref:f},{type:t,...n}))}})}const S=E("bar",Y),ht=E("pie",tt),bt=s("h2",{class:"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"},"Dashboard",-1),xt={class:"py-12"},yt={class:"w-full mx-auto sm:px-6 lg:px-8 mb-10"},_t={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},vt={class:"p-6 text-gray-900 dark:text-gray-100"},Ct={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},wt={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},Dt={class:"p-6 text-gray-900 dark:text-gray-100"},kt={class:"relative z-0 w-full mb-20 group flex gap-5"},Ft=["disabled"],Pt={class:"flex justify-around"},St={class:"min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5"},qt=s("p",{class:"uppercase text-xs text-gray-600 font-bold text-gray-500"},"Total Patient",-1),Ot={class:"text-5xl mt-2"},Bt={class:"min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5"},It=s("p",{class:"uppercase text-xs text-gray-600 font-bold text-gray-500"},"Pedia",-1),At={class:"text-5xl mt-2"},Lt={class:"min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5"},jt=s("p",{class:"uppercase text-xs text-gray-600 font-bold text-gray-500"},"Senior Citizen",-1),Mt={class:"text-5xl mt-2"},Nt={class:"min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5"},Et=s("p",{class:"uppercase text-xs text-gray-600 font-bold text-gray-500"},"Pregnant",-1),Tt={class:"text-5xl mt-2"},Ut={class:"flex gap-10 mt-20"},Vt={class:"flex-1 shadow p-4 flex items-center justify-center flex-col gap-4",style:{height:"400px"}},$t=s("div",{class:"flex-1 shadow p-4 flex items-center justify-center flex-col gap-4",style:{height:"400px"}},null,-1),zt={class:"shadow-md p-4 mt-10"},Qt={__name:"Dashboard_bkp",props:{genderCounts:{type:Array,required:!0},totalPatients:{type:[String,Number],required:!0},disposedItems:{type:Array,required:!0},totalDiagnoses:{type:Array,required:!0},totals:{type:Object},dateFilter:{type:String},stocks:{type:Array}},setup(t){k.register(et,at,st,ot,rt,nt,lt),k.register(it),k.defaults.set("plugins.datalabels",{color:"#fff"});const r=t,n=G({dateFilter:r.dateFilter}),g=()=>{n.get(route("dashboard",{dateFilter}),{preserveScroll:!0})},d=D(c(r.genderCounts)),i=D(b(r.disposedItems)),f=D(w(r.totalDiagnoses)),h=D(v(r.stocks));function y(o){return{responsive:!0,plugins:{title:{display:!0,text:o},datalabels:{color:"#cdcdcd",formatter:e=>e.toLocaleString("en-US")}}}}function c(o){const e=["Male","Female"],a=o.reduce((l,p)=>{const P=p.sex===1?0:1;return l[P]=p.total,l},[0,0]);return{labels:e,datasets:[{data:a,backgroundColor:["#1B065E","#f25cc0"]}]}}function u(o){const e=["#2196F3","#F44336","#FFC107","#4CAF50","#9C27B0"],a=o>e.length?u(o-e.length):[];return e.concat(a)}function _(o){return`hsl(${(300+o*50)%360}, 70%, 50%)`}function b(o){const e=o.sort((a,l)=>a.name.localeCompare(l.name));return{labels:o.map(a=>a.name),datasets:[{label:"Disposed Quantity",data:e.map(a=>parseInt(a.total_quantity)),backgroundColor:u(e.length),borderColor:u(e.length),borderWidth:1}]}}function w(o){const e=o.sort((a,l)=>a.diagnosisName.localeCompare(l.diagnosisName));return{labels:o.map(a=>a.diagnosisName),datasets:[{label:"Diagnosis Total",data:e.map(a=>parseInt(a.total)),backgroundColor:u(e.length),borderColor:u(e.length),borderWidth:1}]}}function v(o){const e=o.sort((l,p)=>p.quantity-l.quantity),a=e.map((l,p)=>_(p));return{labels:o.map(l=>l.name),datasets:[{label:"Current Stock",data:e.map(l=>parseInt(l.quantity)),backgroundColor:a,borderColor:a,borderWidth:1}]}}return(o,e)=>(K(),H(W,null,[x(m(R),{title:"Dashboard"}),x(J,null,{header:B(()=>[bt]),default:B(()=>[s("div",xt,[s("div",yt,[s("div",_t,[s("div",vt,[x(m(S),{class:"mt-10",options:y("Inventory"),data:h.value},null,8,["options","data"])])])]),s("div",Ct,[s("div",wt,[s("div",Dt,[s("div",null,[s("form",{onSubmit:e[1]||(e[1]=Q(a=>g(),["prevent"]))},[s("div",kt,[x(X,{name:"dateFilter",id:"dateFilter",type:"date",class:"mt-1 block w-54",placeholder:" ",modelValue:m(n).dateFilter,"onUpdate:modelValue":e[0]||(e[0]=a=>m(n).dateFilter=a),required:"",autocomplete:"dateFilter"},null,8,["modelValue"]),s("button",{type:"submit",class:Z([{"opacity-25 cursor-not-allowed":m(n).processing},"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto uppercase text-xs px-4 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]),disabled:m(n).processing},"Filter",10,Ft)])],32)]),s("div",Pt,[s("div",St,[qt,s("p",Ot,F(t.totalPatients),1)]),s("div",Bt,[It,s("p",At,F(t.totals.totalPedia),1)]),s("div",Lt,[jt,s("p",Mt,F(t.totals.totalSenior),1)]),s("div",Nt,[Et,s("p",Tt,F(t.totals.totalPregnant),1)])]),s("div",Ut,[s("div",Vt,[x(m(ht),{options:y("Gender"),data:d.value},null,8,["options","data"])]),$t]),s("div",zt,[x(m(S),{options:y("Disposed Items"),data:i.value},null,8,["options","data"])]),x(m(S),{options:y("Diagnoses"),data:f.value,class:"mt-10"},null,8,["options","data"])])])])])]),_:1})],64))}};export{Qt as default};
