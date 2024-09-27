import{k as _,l as U,T as D,m as p,f as n,a as o,u as t,w as b,F as x,o as u,Z as M,b as e,i as C,d as N,e as P,q as m,v as c,t as v,s as w,n as $,S as A}from"./app-CmUxgkoC.js";import{_ as B}from"./AuthenticatedLayout-7q1i4CHE.js";import{_ as i}from"./InputError-FzRQe0fW.js";import{_ as g}from"./TextInput-8Iu5yxWU.js";import{_ as d}from"./InputLabel-PecfvI-M.js";import{u as F}from"./useToast-2YhJonq7.js";import{u as T}from"./useAgeCalculator-7mJTTUHL.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const J=e("h2",{class:"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"}," Create Patient ",-1),L={class:"text-xs text-gray-500 mt-2"},j=e("span",{class:"text-indigo-500"},"Patients",-1),E=e("span",null,"Add Patient",-1),H={class:"max-w-5xl mx-auto py-12 flex justify-center gap-5"},O={class:"max-w-2xl flex-1"},Z={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},G={class:"p-6 text-gray-900 dark:text-gray-100"},K=e("p",{class:"font-bold text-xl"},"Patient Details",-1),Q=e("p",{class:"mb-6 text-xs font-medium text-gray-500"}," Fill out this form to add patient ",-1),R={class:"grid md:grid-cols-3 md:gap-6"},W={class:"relative z-0 w-full mb-6 group"},X={class:"relative z-0 w-full mb-6 group"},Y={class:"relative z-0 w-full mb-6 group"},ee={class:"grid md:grid-cols-3 md:gap-6"},se={class:"relative z-0 w-full mb-6 group"},te=e("option",{value:"",selected:""},null,-1),ae=e("option",{value:"Jr."},"Jr.",-1),oe=e("option",{value:"Sr."},"Sr.",-1),re=e("option",{value:"II"},"II",-1),le=e("option",{value:"III"},"III",-1),ie=e("option",{value:"IV"},"IV",-1),de=e("option",{value:"V"},"V",-1),ne=[te,ae,oe,re,le,ie,de],ue={class:"relative z-0 w-full mb-6 group"},me=e("option",{value:"0"},"Female",-1),ce=e("option",{value:"1"},"Male",-1),ge=[me,ce],fe={class:"relative z-0 w-full mb-6 group"},_e={class:"text-xs font-bold text-blue-500"},pe={class:"grid md:grid-cols-2 md:gap-6"},be={class:"relative z-0 w-full mb-6 group"},xe=e("option",{value:"",selected:""},"Select Here",-1),ve=["value"],he={class:"relative z-0 w-full mb-6 group"},ye=["value"],we=["disabled"],Me={__name:"Create",props:{cities:{type:Array,required:!0},diagnoses:{type:Array,required:!0}},setup(k){const{showToast:V}=F(),{calculateAge:I}=T(),S=k,f=_([]),h=_(""),y=_(null);U(()=>{q()});const s=D({first_name:"",middle_name:"",last_name:"",birthdate:"",sex:"",suffix:null,city_id:"",barangay_id:""});p(()=>s.city_id,async l=>{if(l){const r=await A.get("/api/barangays/"+l);f.value=r.data}else f.value=[]}),p(()=>s.sex,l=>{l==1&&(s.is_pregnant=!1)}),p(()=>s.birthdate,l=>{y.value=I(l)});function z(){s.post(route("patients.store"),{onSuccess:()=>{V(`${s.first_name}, has been registered!`),s.reset()}})}function q(){const l=new Date().toISOString().split("T")[0];h.value=l}return(l,r)=>(u(),n(x,null,[o(t(M),{title:"Create Patient"}),o(B,null,{header:b(()=>[J,e("p",L,[o(t(C),{href:l.route("patients.index")},{default:b(()=>[j]),_:1},8,["href"]),N(" > "),E])]),default:b(()=>[e("div",H,[e("div",O,[e("div",Z,[e("div",G,[K,Q,e("form",{onSubmit:r[8]||(r[8]=P(a=>z(),["prevent"]))},[e("div",R,[e("div",W,[o(d,{for:"first_name",value:"First Name*"}),o(g,{name:"first_name",id:"first_name",type:"text",class:"mt-1 block w-full",placeholder:" ",modelValue:t(s).first_name,"onUpdate:modelValue":r[0]||(r[0]=a=>t(s).first_name=a),autofocus:"",autocomplete:"first_name"},null,8,["modelValue"]),o(i,{class:"mt-2",message:t(s).errors.first_name},null,8,["message"])]),e("div",X,[o(d,{for:"middle_name",value:"Middle Name"}),o(g,{name:"middle_name",id:"middle_name",type:"text",class:"mt-1 block w-full",placeholder:" ",modelValue:t(s).middle_name,"onUpdate:modelValue":r[1]||(r[1]=a=>t(s).middle_name=a),autofocus:"",autocomplete:"middle_name"},null,8,["modelValue"]),o(i,{class:"mt-2",message:t(s).errors.middle_name},null,8,["message"])]),e("div",Y,[o(d,{for:"last_name",value:"Last Name*"}),o(g,{name:"last_name",id:"last_name",type:"text",class:"mt-1 block w-full",placeholder:" ",modelValue:t(s).last_name,"onUpdate:modelValue":r[2]||(r[2]=a=>t(s).last_name=a),required:"",autofocus:"",autocomplete:"last_name"},null,8,["modelValue"]),o(i,{class:"mt-2",message:t(s).errors.last_name},null,8,["message"])])]),e("div",ee,[e("div",se,[o(d,{for:"suffix",value:"Suffix"}),m(e("select",{name:"suffix",id:"suffix","onUpdate:modelValue":r[3]||(r[3]=a=>t(s).suffix=a),class:"w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"},ne,512),[[c,t(s).suffix]]),o(i,{class:"mt-2",message:t(s).errors.suffix},null,8,["message"])]),e("div",ue,[o(d,{for:"sex",value:"Sex*"}),m(e("select",{name:"sex",id:"sex",required:"","onUpdate:modelValue":r[4]||(r[4]=a=>t(s).sex=a),class:"w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"},ge,512),[[c,t(s).sex]]),o(i,{class:"mt-2",message:t(s).errors.sex},null,8,["message"])]),e("div",fe,[o(d,{for:"birthdate",value:"Birthdate*"}),o(g,{name:"birthdate",id:"birthdate",type:"date",class:"mt-1 block w-full",placeholder:" ",modelValue:t(s).birthdate,"onUpdate:modelValue":r[5]||(r[5]=a=>t(s).birthdate=a),required:"",autofocus:"",max:h.value,autocomplete:"birthdate"},null,8,["modelValue","max"]),e("span",_e,v(y.value)+" yrs old",1),o(i,{class:"mt-2",message:t(s).errors.birthdate},null,8,["message"])])]),e("div",pe,[e("div",be,[o(d,{for:"city",value:"Municipality*"}),m(e("select",{name:"city",id:"city","onUpdate:modelValue":r[6]||(r[6]=a=>t(s).city_id=a),required:"",class:"w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"},[xe,(u(!0),n(x,null,w(S.cities,a=>(u(),n("option",{key:a.id,value:a.id},v(a.name),9,ve))),128))],512),[[c,t(s).city_id]]),o(i,{class:"mt-2",message:t(s).errors.city},null,8,["message"])]),e("div",he,[o(d,{for:"barangay",value:"Barangay*"}),m(e("select",{name:"barangay",id:"barangay",required:"","onUpdate:modelValue":r[7]||(r[7]=a=>t(s).barangay_id=a),class:"w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"},[(u(!0),n(x,null,w(f.value,a=>(u(),n("option",{key:a.id,value:a.id},v(a.name),9,ye))),128))],512),[[c,t(s).barangay_id]]),o(i,{class:"mt-2",message:t(s).errors.barangay},null,8,["message"])])]),e("button",{type:"submit",class:$([{"opacity-25 cursor-not-allowed":t(s).processing},"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]),disabled:t(s).processing}," Submit ",10,we)],32)])])])])]),_:1})],64))}};export{Me as default};
