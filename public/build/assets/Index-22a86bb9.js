import{s as j,v as x,j as n,a as c,u as l,w as r,F as m,o as a,X as B,d as u,t as d,b as t,e as C,f as E,g as N,c as h,k as v,l as p,q as k,O}from"./app-108b42dc.js";import{P as V}from"./PrimaryButton-655b7949.js";import{H as w,f as D,_ as A}from"./helper-7f7c44be.js";import{A as I}from"./AuthenticatedLayout-8ec46806.js";import"./_plugin-vue_export-helper-c27b6911.js";const T={class:"my-3 p-3 bg-body rounded shadow-sm"},F=["onSubmit"],H={class:"row mb-3"},K={class:"col-md-3"},L={class:"form-floating mb-3"},M=t("label",{for:"keywordInput"},"Keyword",-1),P={class:"col-12"},q=t("i",{class:"bi bi-search"},null,-1),G={class:"d-grid gap-2 d-md-flex justify-content-md-end mb-3"},R=t("i",{class:"bi bi-plus"},null,-1),U={class:"table table-bordered table-striped table-hover"},X={key:0,width:"10%"},z=t("i",{class:"bi bi-pencil"},null,-1),J=["onClick"],Q=t("i",{class:"bi bi-trash"},null,-1),W=[Q],at={__name:"Index",props:{header:{type:Object},filters:{type:Object},list:{type:Object,default:()=>({})}},setup(i){const g=i,b="statuses",_=j("Status"),s=x(g.filters),S=o=>{s.sort.field=o,s.sort.direction=s.sort.direction==""||s.sort.direction=="desc"?"asc":"desc",y()},y=()=>{s.get(route(b+".index"),{preserveScroll:!0})},$=(o,f)=>{confirm(`Delete this status ${f} ?`)&&O.delete(route(b+".destroy",o))};return(o,f)=>(a(),n(m,null,[c(l(B),{title:_.value},null,8,["title"]),c(I,null,{header:r(()=>[u(d(_.value),1)]),default:r(()=>[t("div",T,[t("form",{onSubmit:C(y,["prevent"])},[t("div",H,[t("div",K,[t("div",L,[E(t("input",{"onUpdate:modelValue":f[0]||(f[0]=e=>l(s).keyword=e),type:"text",class:"form-control",id:"keywordInput",placeholder:"Keyword",autocomplete:"off"},null,512),[[N,l(s).keyword]]),M])]),t("div",P,[c(V,{type:"submit",disabled:l(s).processing},{default:r(()=>[q,u(" Search ")]),_:1},8,["disabled"])])])],40,F),t("div",G,[o.$page.props.auth.isEditable?(a(),h(l(v),{key:0,class:"btn btn-outline-primary btn-sm",href:o.route(b+".create")},{default:r(()=>[R,u(" Create ")]),_:1},8,["href"])):p("",!0)]),t("table",U,[t("thead",null,[t("tr",null,[o.$page.props.auth.isEditable?(a(),h(w,{key:0},{default:r(()=>[u("Actions")]),_:1})):p("",!0),(a(!0),n(m,null,k(i.header,e=>(a(),h(w,{field:e.field,sort:e.sortable?i.filters.sort:null,onSortEvent:S,disabled:l(s).processing},{default:r(()=>[u(d(e.title),1)]),_:2},1032,["field","sort","disabled"]))),256))])]),t("tbody",null,[(a(!0),n(m,null,k(i.list.data,(e,Y)=>(a(),n("tr",null,[o.$page.props.auth.isEditable?(a(),n("td",X,[c(l(v),{href:o.route(b+".edit",e.id),class:"btn btn-sm btn-link"},{default:r(()=>[z]),_:2},1032,["href"]),t("button",{onClick:Z=>$(e.id,e.name),class:"btn btn-sm btn-link"},W,8,J)])):p("",!0),t("td",null,d(e.code),1),t("td",null,d(e.name),1),t("td",null,d(e.state),1),t("td",null,d(l(D)(e.created_at)),1)]))),256))])]),c(A,{data:i.list},null,8,["data"])])]),_:1})],64))}};export{at as default};