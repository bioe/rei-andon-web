import{l as c,h as p,a as t,u as l,w as o,F as u,o as m,X as h,d as n,t as f,b as a,B as b,C as v,i as _,e as y}from"./app-1c063c3a.js";import{A as g}from"./AuthenticatedLayout-b947170a.js";import B from"./DetailForm-1c0b5fda.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./InputError-28a5039e.js";import"./InputLabel-602967cc.js";import"./TextInput-5026e7eb.js";import"./PrimaryButton-8e6a2db9.js";const k={class:"card"},w=a("div",{class:"card-header"},[a("ul",{class:"nav nav-tabs card-header-tabs"},[a("li",{class:"nav-item"},[a("a",{class:"nav-link active","data-bs-toggle":"tab",href:"#tab_1"},"Details")])])],-1),N={class:"card-body"},P={class:"tab-content"},T={class:"tab-pane fade pt-10 show active",id:"tab_1",role:"tabpanel","aria-labelledby":"tab_1"},V={class:"card-footer"},$={class:"col-12"},G={__name:"EditPartial",props:{data:{type:Object,default:()=>({})}},setup(r){const s="machinetypes",i=c("Machine Types");return(e,d)=>(m(),p(u,null,[t(l(h),{title:i.value},null,8,["title"]),t(g,null,{header:o(()=>[n(f(i.value),1)]),default:o(()=>[a("form",{onSubmit:d[0]||(d[0]=y(A=>r.data.id==null?e.form.post(e.route(s+".store")):e.form.patch(e.route(s+".update",r.data.id)),["prevent"]))},[a("div",k,[w,a("div",N,[a("div",P,[a("div",T,[t(B,b(v(e.$props)),null,16)])])]),a("div",V,[a("div",$,[t(l(_),{class:"btn btn-secondary me-2",href:e.route(s+".index")},{default:o(()=>[n("Back")]),_:1},8,["href"])])])])],32)]),_:1})],64))}};export{G as default};