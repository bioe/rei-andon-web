import{l as u,v as N,c as B,w as m,o as d,a as o,u as e,X as S,b as s,n as v,f as U,g as W,h as w,d as y,F as b,i as A,e as M,m as C}from"./app-9a9cc906.js";import{_ as $}from"./InputLabel-96097103.js";import{_ as I,G as F}from"./GuestPrimaryButton-c08cf9d2.js";import{_ as G}from"./InputError-81ec9652.js";import{_ as k}from"./Alert-667c1f1f.js";import{T as q}from"./vue3-treeselect.min-ed648836.js";import"./_plugin-vue_export-helper-c27b6911.js";const z=s("h1",{class:"h3 mb-3 fw-normal"},"Andon Watch Login",-1),D=["onSubmit"],H={class:"text-start"},O=s("label",{for:"floatingUsername"},"Employee Code",-1),P=s("span",{class:"spinner-grow spinner-grow-sm","aria-hidden":"true"},null,-1),R=s("span",{role:"status"},"Connecting...",-1),X={class:"mt-4"},ae={__name:"WatchLogin",props:{timeout_sec:{type:Number},watch_login_log_id:{type:Number}},setup(x){const _=x,l=u(!1),i=u(""),c=u(""),a=N({watch_code:null,username:""}),L=()=>{l.value=!0,c.value="",i.value="",a.post(route("watch_login.main"),{onSuccess:n=>T(),onError:()=>l.value=!1})};let f=null,g=null;const T=()=>{f=setInterval(V,1e3,_.watch_login_log_id),g=setTimeout(()=>{h(),c.value="Unable to login, please try again."},_.timeout_sec)};function V(n){C.get(route("watch_login.is_login",n)).then(function(t){t.data.success&&(h(),a.reset(),i.value=t.data.message)}).catch(function(){})}function h(){clearInterval(f),clearTimeout(g),l.value=!1}function E({action:n,searchQuery:t,callback:r}){n==="ASYNC_SEARCH"&&C.get(route("watch_login.available",{keyword:t})).then(function(p){console.log(p.data),r(null,p.data)})}return(n,t)=>(d(),B(I,null,{default:m(()=>[o(e(S),{title:"Watch Login"}),z,o(k,{message:i.value,status:"success"},null,8,["message"]),o(k,{message:c.value,status:"danger"},null,8,["message"]),s("form",{onSubmit:M(L,["prevent"])},[s("div",H,[o($,{for:"watch",value:"Watch Code"}),o(e(q),{modelValue:e(a).watch_code,"onUpdate:modelValue":t[0]||(t[0]=r=>e(a).watch_code=r),async:!0,"load-options":E,placeholder:"Enter Watch Code"},null,8,["modelValue"])]),s("div",{class:v(["form-floating my-2",{"is-invalid":e(a).errors.username}])},[U(s("input",{type:"text",class:v(["form-control",{"is-invalid":e(a).errors.username}]),id:"floatingUsername","onUpdate:modelValue":t[1]||(t[1]=r=>e(a).username=r),placeholder:"Employee Code",required:"",autocomplete:"false"},null,2),[[W,e(a).username]]),O],2),o(G,{class:"my-1",message:e(a).errors.username},null,8,["message"]),o(F,{disabled:l.value},{default:m(()=>[l.value?(d(),w(b,{key:0},[P,R],64)):(d(),w(b,{key:1},[y(" Log in ")],64))]),_:1},8,["disabled"]),s("div",X,[o(e(A),{href:n.route("login")},{default:m(()=>[y(" Admin Login ")]),_:1},8,["href"])])],40,D)]),_:1}))}};export{ae as default};