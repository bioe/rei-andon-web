import{s as f,v as h,j as b,a as s,u as a,w as r,F as y,o as g,X as k,d as m,t as V,b as e,k as w,e as A}from"./app-a00b55ef.js";import{_}from"./InputError-a8a2b779.js";import{_ as v}from"./InputLabel-81ef9842.js";import{_ as p}from"./TextInput-d9e00c42.js";import{P as B}from"./PrimaryButton-0ccf51a5.js";import{_ as $}from"./Checkbox-227949a1.js";import{A as x}from"./AuthenticatedLayout-9537a59f.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ApplicationLogo-11791e67.js";const N={class:"card"},T=e("div",{class:"card-header"},[e("ul",{class:"nav nav-tabs card-header-tabs"},[e("li",{class:"nav-item"},[e("a",{class:"nav-link active","data-bs-toggle":"tab",href:"#tab_1"},"Details")])])],-1),C={class:"card-body"},L={class:"tab-content"},M={class:"tab-pane fade pt-10 show active",id:"tab_1",role:"tabpanel","aria-labelledby":"tab_1"},P={class:"row g-3"},S={class:"col-md-4"},U={class:"col-md-4"},j={class:"col-12"},q={class:"card-footer"},D={class:"col-12"},J={__name:"Edit",props:{data:{type:Object,default:()=>({})}},setup(i){const l=i,n="watches",u=f("Watch"),t=h({code:l.data.code??"",ip_address:l.data.ip_address??"",active:l.data.active});return(c,d)=>(g(),b(y,null,[s(a(k),{title:u.value},null,8,["title"]),s(x,null,{header:r(()=>[m(V(u.value),1)]),default:r(()=>[e("form",{onSubmit:d[3]||(d[3]=A(o=>i.data.id==null?a(t).post(c.route(n+".store")):a(t).patch(c.route(n+".update",i.data.id)),["prevent"]))},[e("div",N,[T,e("div",C,[e("div",L,[e("div",M,[e("div",P,[e("div",S,[s(v,{for:"code",value:"Code"}),s(p,{id:"code",type:"text",modelValue:a(t).code,"onUpdate:modelValue":d[0]||(d[0]=o=>a(t).code=o),invalid:a(t).errors.code,required:""},null,8,["modelValue","invalid"]),s(_,{message:a(t).errors.code},null,8,["message"])]),e("div",U,[s(v,{for:"ip_address",value:"IP Address"}),s(p,{id:"ip_address",type:"text",modelValue:a(t).ip_address,"onUpdate:modelValue":d[1]||(d[1]=o=>a(t).ip_address=o),invalid:a(t).errors.ip_address,required:""},null,8,["modelValue","invalid"]),s(_,{message:a(t).errors.ip_address},null,8,["message"])]),e("div",j,[s($,{id:"checkActive",checked:a(t).active,"onUpdate:checked":d[2]||(d[2]=o=>a(t).active=o)},{default:r(()=>[m(" Active ")]),_:1},8,["checked"])])])])])]),e("div",q,[e("div",D,[s(a(w),{class:"btn btn-secondary me-2",href:c.route(n+".index")},{default:r(()=>[m("Back")]),_:1},8,["href"]),s(B,{type:"submit",innerHTML:i.data.id==null?"Create":"Save"},null,8,["innerHTML"])])])])],32)]),_:1})],64))}};export{J as default};