import{s as c,j as p,a as t,u as l,w as o,F as u,o as m,X as f,d as n,t as h,b as a,z as b,A as v,k as _,e as y}from"./app-108b42dc.js";import{A as g}from"./AuthenticatedLayout-8ec46806.js";import k from"./DetailForm-fa5f0c2d.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./InputError-1bce922b.js";import"./InputLabel-5937abbf.js";import"./TextInput-dc47fd4d.js";import"./PrimaryButton-655b7949.js";const w={class:"card"},B=a("div",{class:"card-header"},[a("ul",{class:"nav nav-tabs card-header-tabs"},[a("li",{class:"nav-item"},[a("a",{class:"nav-link active","data-bs-toggle":"tab",href:"#tab_1"},"Details")])])],-1),N={class:"card-body"},A={class:"tab-content"},P={class:"tab-pane fade pt-10 show active",id:"tab_1",role:"tabpanel","aria-labelledby":"tab_1"},T={class:"card-footer"},V={class:"col-12"},G={__name:"EditPartial",props:{data:{type:Object,default:()=>({})}},setup(r){const s="machinetypes",i=c("Machine Types");return(e,d)=>(m(),p(u,null,[t(l(f),{title:i.value},null,8,["title"]),t(g,null,{header:o(()=>[n(h(i.value),1)]),default:o(()=>[a("form",{onSubmit:d[0]||(d[0]=y($=>r.data.id==null?e.form.post(e.route(s+".store")):e.form.patch(e.route(s+".update",r.data.id)),["prevent"]))},[a("div",w,[B,a("div",N,[a("div",A,[a("div",P,[t(k,b(v(e.$props)),null,16)])])]),a("div",T,[a("div",V,[t(l(_),{class:"btn btn-secondary me-2",href:e.route(s+".index")},{default:o(()=>[n("Back")]),_:1},8,["href"])])])])],32)]),_:1})],64))}};export{G as default};