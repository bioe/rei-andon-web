import{l as c,h as p,a as e,u as l,w as o,F as u,o as m,X as h,d as n,t as f,b as a,B as b,C as v,i as _,e as y}from"./app-5e233097.js";import{A as g}from"./AuthenticatedLayout-2a69091e.js";import B from"./DetailForm-f3c6f54c.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./FlashAlert-2f675c77.js";import"./InputError-e8acc2d8.js";import"./InputLabel-c0a77240.js";import"./TextInput-aa49bfb2.js";import"./PrimaryButton-7e35f08e.js";const k={class:"card"},w=a("div",{class:"card-header"},[a("ul",{class:"nav nav-tabs card-header-tabs"},[a("li",{class:"nav-item"},[a("a",{class:"nav-link active","data-bs-toggle":"tab",href:"#tab_1"},"Details")])])],-1),N={class:"card-body"},P={class:"tab-content"},T={class:"tab-pane fade pt-10 show active",id:"tab_1",role:"tabpanel","aria-labelledby":"tab_1"},V={class:"card-footer"},$={class:"col-12"},L={__name:"EditPartial",props:{data:{type:Object,default:()=>({})}},setup(r){const s="machinetypes",i=c("Machine Types");return(t,d)=>(m(),p(u,null,[e(l(h),{title:i.value},null,8,["title"]),e(g,null,{header:o(()=>[n(f(i.value),1)]),default:o(()=>[a("form",{onSubmit:d[0]||(d[0]=y(A=>r.data.id==null?t.form.post(t.route(s+".store")):t.form.patch(t.route(s+".update",r.data.id)),["prevent"]))},[a("div",k,[w,a("div",N,[a("div",P,[a("div",T,[e(B,b(v(t.$props)),null,16)])])]),a("div",V,[a("div",$,[e(l(_),{class:"btn btn-secondary me-2",href:t.route(s+".index")},{default:o(()=>[n("Back")]),_:1},8,["href"])])])])],32)]),_:1})],64))}};export{L as default};