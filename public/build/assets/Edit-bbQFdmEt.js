import{T as w,f as n,a as o,u as e,w as m,F as f,o as c,Z as k,b as t,i as b,d as y,t as g,e as V,g as z,q as U,v as q,s as $,n as R}from"./app-CmUxgkoC.js";import{_ as S}from"./AuthenticatedLayout-7q1i4CHE.js";import{_ as d}from"./TextInput-8Iu5yxWU.js";import{_ as r}from"./InputLabel-PecfvI-M.js";import{_ as i}from"./InputError-FzRQe0fW.js";import{_ as v}from"./Checkbox-xtvmmrbo.js";import{u as M}from"./useToast-2YhJonq7.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const B=t("h2",{class:"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"},"Edit Medical Record",-1),E={class:"text-xs text-gray-500 mt-2"},N=t("span",{class:"text-indigo-500"},"Patients",-1),P={class:"uppercase text-indigo-500"},T=t("span",null,"Edit Medical Record",-1),D={class:"py-12"},C={class:"max-w-2xl mx-auto sm:px-6 lg:px-8"},O={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},F={class:"p-6 text-gray-900 dark:text-gray-100"},j={class:"text-xl font-bold text-cyan-700 uppercase mb-6"},A={class:"grid md:grid-cols-3 md:gap-6"},L={class:"relative z-0 w-full mb-6 group"},Z={class:"flex items-center"},G=t("span",{class:"ms-2 text-sm text-gray-600 dark:text-gray-400"},"Needs Opto",-1),H={key:0,class:"relative z-0 w-full mb-6 group"},I={class:"flex items-center"},J=t("span",{class:"ms-2 text-sm text-gray-600 dark:text-gray-400"},"Pregnant",-1),K={class:"grid md:grid-cols-3 md:gap-6"},Q={class:"relative z-0 w-full mb-6 group"},W={class:"relative z-0 w-full mb-6 group"},X={class:"relative z-0 w-full mb-6 group"},Y={class:"grid md:grid-cols-3 md:gap-6"},ee={class:"relative z-0 w-full mb-6 group"},se={class:"relative z-0 w-full mb-6 group"},te={class:"relative z-0 w-full mb-6 group"},oe={class:"relative z-0 w-full mb-6 group"},ae=t("option",{value:"",selected:""},"-",-1),le=["value"],re=["disabled"],ge={__name:"Edit",props:{medical_record:{type:Object,required:!0},full_name:{type:String,required:!0},diagnoses:{type:Array,required:!0}},setup(p){const{showToast:x}=M(),u=p,s=w({...u.medical_record}),h=()=>{s.put(route("medical-records.update",[u.medical_record.id]),{onSuccess:()=>{x(`${u.full_name}, medical record updated!`),s.reset()}})};return(_,l)=>(c(),n(f,null,[o(e(k),{title:"Medical Record - Edit"}),o(S,null,{header:m(()=>[B,t("p",E,[o(e(b),{href:_.route("patients.index")},{default:m(()=>[N]),_:1},8,["href"]),y(" > "),o(e(b),{href:_.route("patients.show",_.$props.medical_record.patient.id)},{default:m(()=>[t("span",P,g(p.full_name),1)]),_:1},8,["href"]),y(" > "),T])]),default:m(()=>[t("div",D,[t("div",C,[t("div",O,[t("div",F,[t("h1",j,g(p.full_name)+" - Medical Record",1),t("form",{onSubmit:l[9]||(l[9]=V(a=>h(),["prevent"]))},[t("div",A,[t("div",L,[t("label",Z,[o(v,{checked:e(s).is_opto==1,name:"remember","onUpdate:checked":l[0]||(l[0]=a=>e(s).is_opto=a)},null,8,["checked"]),G])]),e(s).patient.sex=="0"?(c(),n("div",H,[t("label",I,[o(v,{name:"remember",checked:e(s).is_pregnant==1,"onUpdate:checked":l[1]||(l[1]=a=>e(s).is_pregnant=a)},null,8,["checked"]),J])])):z("",!0)]),t("div",K,[t("div",Q,[o(r,{for:"temperature",value:"Temperature* (deg)"}),o(d,{name:"temperature",id:"temperature",type:"number",step:"0.1",class:"mt-1 block w-full",placeholder:" ",modelValue:e(s).temperature,"onUpdate:modelValue":l[2]||(l[2]=a=>e(s).temperature=a),required:"",autofocus:"",autocomplete:"temperature"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.temperature},null,8,["message"])]),t("div",W,[o(r,{for:"bp_systolic",value:"BP Systolic*"}),o(d,{name:"bp_systolic",id:"bp_systolic",type:"number",class:"mt-1 block w-full",placeholder:"120",modelValue:e(s).bp_systolic,"onUpdate:modelValue":l[3]||(l[3]=a=>e(s).bp_systolic=a),required:"",autofocus:"",autocomplete:"bp_systolic"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.temperature},null,8,["message"])]),t("div",X,[o(r,{for:"bp_diastolic",value:"BP Diastolic*"}),o(d,{name:"bp_diastolic",id:"bp_diastolic",type:"number",class:"mt-1 block w-full",placeholder:"80",modelValue:e(s).bp_diastolic,"onUpdate:modelValue":l[4]||(l[4]=a=>e(s).bp_diastolic=a),required:"",autofocus:"",autocomplete:"bp_diastolic"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.bp_diastolic},null,8,["message"])])]),t("div",Y,[t("div",ee,[o(r,{for:"respiratory_rate",value:"Respiratory Rate"}),o(d,{name:"respiratory_rate",id:"respiratory_rate",type:"number",class:"mt-1 block w-full",placeholder:" ",modelValue:e(s).respiratory_rate,"onUpdate:modelValue":l[5]||(l[5]=a=>e(s).respiratory_rate=a),autofocus:"",autocomplete:"respiratory_rate"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.respiratory_rate},null,8,["message"])]),t("div",se,[o(r,{for:"oxygen_saturation",value:"Oxygen Saturation (%)"}),o(d,{name:"oxygen_saturation",id:"oxygen_saturation",type:"number",class:"mt-1 block w-full",placeholder:" ",modelValue:e(s).oxygen_saturation,"onUpdate:modelValue":l[6]||(l[6]=a=>e(s).oxygen_saturation=a),autofocus:"",autocomplete:"oxygen_saturation"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.oxygen_saturation},null,8,["message"])]),t("div",te,[o(r,{for:"pulse_rate",value:"Pulse Rate"}),o(d,{name:"pulse_rate",id:"pulse_rate",type:"number",class:"mt-1 block w-full",placeholder:" ",modelValue:e(s).pulse_rate,"onUpdate:modelValue":l[7]||(l[7]=a=>e(s).pulse_rate=a),autofocus:"",autocomplete:"pulse_rate"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.pulse_rate},null,8,["message"])]),t("div",oe,[o(r,{for:"diagnosis_id",value:"Diagnosis"}),U(t("select",{name:"diagnosis_id",id:"diagnosis_id","onUpdate:modelValue":l[8]||(l[8]=a=>e(s).diagnosis_id=a),required:"",class:"w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"},[ae,(c(!0),n(f,null,$(u.diagnoses,a=>(c(),n("option",{key:a.id,value:a.id},g(a.name),9,le))),128))],512),[[q,e(s).diagnosis_id]]),o(i,{class:"mt-2",message:e(s).errors.diagnosis_id},null,8,["message"])])]),t("button",{type:"submit",class:R([{"opacity-25 cursor-not-allowed":e(s).processing},"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]),disabled:e(s).processing},"Update",10,re)],32)])])])])]),_:1})],64))}};export{ge as default};
