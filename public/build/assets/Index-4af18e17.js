import{s as x,v as S,j as f,a as l,u as o,w as a,F as m,o as n,X as j,d as i,t as c,b as t,e as B,f as O,g as C,k as p,q as y,c as D,O as N}from"./app-c4062057.js";import{P as V}from"./PrimaryButton-1365476c.js";import{H as v,f as A,_ as I}from"./helper-617a2961.js";import{A as T}from"./AuthenticatedLayout-f739eaa9.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ApplicationLogo-df4afa88.js";const $={class:"my-3 p-3 bg-body rounded shadow-sm"},E=["onSubmit"],F={class:"row mb-3"},H={class:"col-md-3"},K={class:"form-floating mb-3"},L=t("label",{for:"keywordInput"},"Keyword",-1),M={class:"col-12"},P=t("i",{class:"bi bi-search"},null,-1),q={class:"d-grid gap-2 d-md-flex justify-content-md-end mb-3"},G=t("i",{class:"bi bi-plus"},null,-1),R={class:"table table-bordered table-striped table-hover"},U={width:"10%"},W=t("i",{class:"bi bi-pencil"},null,-1),X=["onClick"],z=t("i",{class:"bi bi-trash"},null,-1),J=[z],at={__name:"Index",props:{header:{type:Object},filters:{type:Object},list:{type:Object,default:()=>({})}},setup(d){const w=d,u="watches",_=x("Watch"),s=S(w.filters),k=r=>{s.sort.field=r,s.sort.direction=s.sort.direction==""||s.sort.direction=="desc"?"asc":"desc",h()},h=()=>{s.get(route(u+".index"),{preserveScroll:!0})},g=(r,b)=>{confirm(`Delete this status ${b} ?`)&&N.delete(route(u+".destroy",r))};return(r,b)=>(n(),f(m,null,[l(o(j),{title:_.value},null,8,["title"]),l(T,null,{header:a(()=>[i(c(_.value),1)]),default:a(()=>[t("div",$,[t("form",{onSubmit:B(h,["prevent"])},[t("div",F,[t("div",H,[t("div",K,[O(t("input",{"onUpdate:modelValue":b[0]||(b[0]=e=>o(s).keyword=e),type:"text",class:"form-control",id:"keywordInput",placeholder:"Keyword",autocomplete:"off"},null,512),[[C,o(s).keyword]]),L])]),t("div",M,[l(V,{type:"submit",disabled:o(s).processing},{default:a(()=>[P,i(" Search ")]),_:1},8,["disabled"])])])],40,E),t("div",q,[l(o(p),{class:"btn btn-outline-primary btn-sm",href:r.route(u+".create")},{default:a(()=>[G,i(" Create ")]),_:1},8,["href"])]),t("table",R,[t("thead",null,[t("tr",null,[l(v,null,{default:a(()=>[i("Actions")]),_:1}),(n(!0),f(m,null,y(d.header,e=>(n(),D(v,{field:e.field,sort:e.sortable?d.filters.sort:null,onSortEvent:k,disabled:o(s).processing},{default:a(()=>[i(c(e.title),1)]),_:2},1032,["field","sort","disabled"]))),256))])]),t("tbody",null,[(n(!0),f(m,null,y(d.list.data,(e,Q)=>(n(),f("tr",null,[t("td",U,[l(o(p),{href:r.route(u+".edit",e.id),class:"btn btn-sm btn-link"},{default:a(()=>[W]),_:2},1032,["href"]),t("button",{onClick:Y=>g(e.id,e.name),class:"btn btn-sm btn-link"},J,8,X)]),t("td",null,c(e.code),1),t("td",null,c(e.ip_address),1),t("td",null,c(o(A)(e.created_at)),1)]))),256))])]),l(I,{data:d.list},null,8,["data"])])]),_:1})],64))}};export{at as default};