import{v as c,c as u,w as l,o as p,a as o,u as e,X as f,b as a,n as t,f as _,g as w,d as g,e as b,r as v}from"./app-62317b19.js";import{_ as y,G as h}from"./GuestPrimaryButton-edcbf256.js";import{_ as x}from"./InputError-4bdbe9de.js";import"./_plugin-vue_export-helper-c27b6911.js";const k=a("div",{class:"mb-4 text-start"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),B=["onSubmit"],E=a("label",{for:"floatingEmail"},"Email address",-1),S={__name:"ForgotPassword",props:{status:{type:String}},setup(i){const s=c({email:""}),m=()=>{s.post(route("password.email"))};return(N,r)=>{const n=v("Alert");return p(),u(y,null,{default:l(()=>[o(e(f),{title:"Forgot Password"}),k,o(n,{message:i.status},null,8,["message"]),a("form",{onSubmit:b(m,["prevent"])},[a("div",{class:t(["form-floating",{"is-invalid":e(s).errors.email}])},[_(a("input",{type:"email",class:t(["form-control",{"is-invalid":e(s).errors.email}]),id:"floatingEmail",placeholder:"name@example.com",required:"",autofocus:"","onUpdate:modelValue":r[0]||(r[0]=d=>e(s).email=d)},null,2),[[w,e(s).email]]),E],2),o(x,{class:"my-1",message:e(s).errors.email},null,8,["message"]),o(h,{class:t(["mt-4",{"opacity-25":e(s).processing}]),disabled:e(s).processing},{default:l(()=>[g(" Email Password Reset Link ")]),_:1},8,["class","disabled"])],40,B)]),_:1})}}};export{S as default};