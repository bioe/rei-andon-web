import{l as O,v as V,h as n,a as b,u as l,w as u,F as _,o as d,X as j,d as a,t as s,b as e,e as A,f as g,g as I,A as N,z as m,c as w,j as p,O as $}from"./app-9ccc99ce.js";import{P as C}from"./PrimaryButton-60cb4bf1.js";import{H as k,f,_ as D}from"./helper-b2935596.js";import{A as E}from"./AuthenticatedLayout-b89d1d63.js";import"./_plugin-vue_export-helper-c27b6911.js";const z={class:"my-3 p-3 bg-body rounded shadow-sm"},M=["onSubmit"],T={class:"row mb-3"},F={class:"col-md-3"},H={class:"form-floating mb-3"},K=e("label",{for:"keywordInput"},"Keyword",-1),L={class:"col-md-3"},P={class:"form-floating mb-3"},R=e("option",{value:null},"All",-1),U=["value"],G=e("label",{for:"zoneInput"},"Zone",-1),X={class:"col-12"},Z=e("i",{class:"bi bi-search"},null,-1),q={class:"table table-bordered table-striped table-hover"},J={key:0,width:"10%"},Q=["onClick"],W=e("i",{class:"bi bi-trash"},null,-1),Y=[W],ee=e("br",null,null,-1),te=e("br",null,null,-1),ie={__name:"Index",props:{header:{type:Object},filters:{type:Object},list:{type:Object,default:()=>({})},segments:{type:Object}},setup(r){const x=r,h="statusrecords",y=O("Records"),o=V(x.filters),S=i=>{o.sort.field=i,o.sort.direction=o.sort.direction==""||o.sort.direction=="desc"?"asc":"desc",v()},v=()=>{o.get(route(h+".index"),{preserveScroll:!0})},B=(i,c)=>{confirm(`Delete this status ${c} ?`)&&$.delete(route(h+".destroy",i))};return(i,c)=>(d(),n(_,null,[b(l(j),{title:y.value},null,8,["title"]),b(E,null,{header:u(()=>[a(s(y.value),1)]),default:u(()=>[e("div",z,[e("form",{onSubmit:A(v,["prevent"])},[e("div",T,[e("div",F,[e("div",H,[g(e("input",{"onUpdate:modelValue":c[0]||(c[0]=t=>l(o).keyword=t),type:"text",class:"form-control",id:"keywordInput",placeholder:"Keyword",autocomplete:"off"},null,512),[[I,l(o).keyword]]),K])]),e("div",L,[e("div",P,[g(e("select",{"onUpdate:modelValue":c[1]||(c[1]=t=>l(o).segment_code=t),class:"form-select",id:"zoneInput"},[R,(d(!0),n(_,null,m(r.segments,t=>(d(),n("option",{value:t.code},s(t.code),9,U))),256))],512),[[N,l(o).segment_code]]),G])]),e("div",X,[b(C,{type:"submit",disabled:l(o).processing},{default:u(()=>[Z,a(" Search ")]),_:1},8,["disabled"])])])],40,M),e("table",q,[e("thead",null,[e("tr",null,[i.$page.props.auth.isEditable?(d(),w(k,{key:0},{default:u(()=>[a("Actions")]),_:1})):p("",!0),(d(!0),n(_,null,m(r.header,t=>(d(),w(k,{field:t.field,sort:t.sortable?r.filters.sort:null,onSortEvent:S,disabled:l(o).processing},{default:u(()=>[a(s(t.title),1)]),_:2},1032,["field","sort","disabled"]))),256))])]),e("tbody",null,[(d(!0),n(_,null,m(r.list.data,(t,se)=>(d(),n("tr",null,[i.$page.props.auth.isEditable?(d(),n("td",J,[e("button",{onClick:oe=>B(t.id,t.id),class:"btn btn-sm btn-link"},Y,8,Q)])):p("",!0),e("td",null,s(t.machine_code),1),e("td",null,s(t.segment_code),1),e("td",null,s(t.employee_code),1),e("td",null,s(l(f)(t.created_at)),1),e("td",null,[a(s(t.status.code),1),ee,a(" "+s(t.status.name),1)]),e("td",null,[a(s(l(f)(t.last_responsed_at))+" ",1),t.last_responsed_employee?(d(),n(_,{key:0},[te,a(" By: "+s(t.last_responsed_employee),1)],64)):p("",!0)]),e("td",null,s(l(f)(t.attended_at)),1),e("td",null,s(l(f)(t.resolved_at)),1)]))),256))])]),b(D,{data:r.list},null,8,["data"])])]),_:1})],64))}};export{ie as default};