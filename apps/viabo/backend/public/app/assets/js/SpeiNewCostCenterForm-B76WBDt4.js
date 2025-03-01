import{c as U,f as F,U as v,i as e,S as o,T as N,B as b,b4 as D,dN as q,e6 as O,e1 as R,e7 as w,aT as I,dj as W,dn as V,Q as B,P as j}from"./vendor-5lkxkETF.js";import{u as Q}from"./formik.esm-CTTSENmf.js";import{c as k,a as l,d as T}from"./index.esm-gIIytEq8.js";import{g as P,b as L}from"./index-DkbAsBWZ.js";import{M as m,n as $,S as z,a as G}from"./useFindSpeiCostCenters-Ddo3tJFS.js";import{i as A}from"./matchTypes-mENztEWg.js";import{F as H,R as C}from"./TextMaxLine-B63DtfW-.js";import{R as K}from"./RFSelect-DSsw7uR8.js";import"./formatTime-jCgU2sMR.js";import"./UploadSingleFile-ByYCreVQ.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";import"./formatNumber-dGNhWwxT.js";const Y=r=>{var n,s,E,c,u,t;return{name:(n=r==null?void 0:r.name)==null?void 0:n.trim(),isNewUser:(r==null?void 0:r.method)===m.NEW_ADMIN_USER,assignedUsers:((s=r==null?void 0:r.adminUsers)==null?void 0:s.map(d=>d.value))||[],userName:(E=r==null?void 0:r.adminName)==null?void 0:E.trim(),userLastName:(c=r==null?void 0:r.adminLastName)==null?void 0:c.trim(),userEmail:(u=r==null?void 0:r.adminEmail)==null?void 0:u.trim(),userPhone:(t=r==null?void 0:r.adminPhone)==null?void 0:t.trim()}},J=(r={})=>{const n=U(),s=F($,r);return{...s,mutate:async(c,u)=>{const{onSuccess:t,onError:d,mutationOptions:g}=u;try{await v.promise(s.mutateAsync(c,g),{pending:"Creando centro de costos...",success:{render({data:i}){return n.invalidateQueries([z.COST_CENTERS_LIST]),A(t)&&t(i),"Se creó el centro de costos con éxito"}}})}catch(i){const p=P(i,"No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas");A(d)&&d(p),v.error(p,{type:L(i)})}}}},X=(r={})=>{const n=U(),s=F(G,r);return{...s,mutate:async(c,u)=>{const{onSuccess:t,onError:d,mutationOptions:g}=u;try{await v.promise(s.mutateAsync(c,g),{pending:"Actualizando centro de costos...",success:{render({data:i}){return n.invalidateQueries([z.COST_CENTERS_LIST]),A(t)&&t(i),"Se actualizó el centro de costos con éxito"}}})}catch(i){const p=P(i,"No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas");A(d)&&d(p),v.error(p,{type:L(i)})}}}},Z=({adminUsers:r,onSuccess:n,costCenter:s})=>{const{mutate:E,isLoading:c}=J(),{mutate:u,isLoading:t}=X(),d=k().shape({name:l().trim().max(60,"Máximo 60 caracteres").required("Es necesario el nombre del centro de costos"),method:l(),adminUsers:T().when("method",{is:m.ADMIN_USERS,then:a=>a.min(1,"Es necesario al menos un usuario administrador asignado al centro de costos"),otherwise:a=>T()}),adminName:l().trim().when("method",{is:m.NEW_ADMIN_USER,then:a=>a.required("Es necesario el nombre del administrador"),otherwise:a=>l().trim()}),adminLastName:l().trim().when("method",{is:m.NEW_ADMIN_USER,then:a=>a.required("Es necesario los apellidos del administrador"),otherwise:a=>l().trim()}),adminEmail:l().trim().email("Ingrese un correo valido").when("method",{is:m.NEW_ADMIN_USER,then:a=>a.required("Es necesario el correo del administrador"),otherwise:a=>l().trim().email("Ingrese un correo valido")}),adminPhone:l().trim()}),g=(r==null?void 0:r.filter(a=>{var x;return(x=s==null?void 0:s.adminUsers)==null?void 0:x.includes(a==null?void 0:a.value)}))||[],i=Q({initialValues:{name:(s==null?void 0:s.name)||"",method:m.ADMIN_USERS,adminUsers:g,adminName:"",adminLastName:"",adminEmail:"",adminPhone:""},enableReinitialize:!0,validationSchema:d,onSubmit:(a,{setSubmitting:x,setFieldValue:y})=>{const f=Y(a);return s?u({...f,id:s==null?void 0:s.id},{onSuccess:()=>{n(),x(!1)},onError:()=>{x(!1)}}):E(f,{onSuccess:()=>{n(),x(!1)},onError:()=>{x(!1)}})}}),{isSubmitting:p,setFieldValue:S,values:_,setTouched:M}=i,h=p||c||t;return e.jsx(H,{formik:i,children:e.jsxs(o,{spacing:2,children:[e.jsxs(o,{spacing:1,children:[e.jsxs(N,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:["Nombre",e.jsx(b,{component:"span",color:"error.main",ml:.5,children:"*"})]}),e.jsx(C,{inputProps:{maxLength:"60"},required:!0,name:"name",size:"small",disabled:h,placeholder:"Nombre del Centro de Costos..."})]}),e.jsx(o,{children:e.jsxs(D,{disabled:h,children:[e.jsx(q,{id:"demo-row-radio-buttons-group-label",children:"Seleccione al administrador del centro de costos:"}),e.jsxs(O,{value:_.method,onChange:a=>{!s&&S("adminUsers",[]),S("adminName",""),S("adminLastName",""),S("adminEmail",""),S("adminPhone",""),S("method",a.target.value),M({},!1)},row:!0,"aria-labelledby":"demo-row-radio-buttons-group-label",name:"row-radio-buttons-group",children:[e.jsx(R,{value:m.ADMIN_USERS,control:e.jsx(w,{}),label:"Administrador de Centro de Costos Existente"}),e.jsx(R,{value:m.NEW_ADMIN_USER,control:e.jsx(w,{}),label:"Nuevo Administrador de Centro de Costos"})]})]})}),_.method===m.ADMIN_USERS?e.jsxs(o,{spacing:1,children:[e.jsxs(N,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:["Usuarios Administradores",e.jsx(b,{component:"span",color:"error.main",ml:.5,children:"*"})]}),e.jsx(K,{multiple:!0,name:"adminUsers",textFieldParams:{placeholder:"Seleccionar ...",size:"small"},options:r||[],disabled:h})]}):e.jsxs(e.Fragment,{children:[e.jsxs(o,{spacing:1,children:[e.jsxs(N,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:["Nombre (s)",e.jsx(b,{component:"span",color:"error.main",ml:.5,children:"*"})]}),e.jsx(C,{name:"adminName",size:"small",required:!0,placeholder:"Nombre Administrador del Centro de Costos...",disabled:h})]}),e.jsxs(o,{spacing:1,children:[e.jsxs(N,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:["Apellido (s)",e.jsx(b,{component:"span",color:"error.main",ml:.5,children:"*"})]}),e.jsx(C,{name:"adminLastName",size:"small",required:!0,placeholder:"Apellidos del Administrador del Centro de Costos...",disabled:h})]}),e.jsxs(o,{flexDirection:{md:"row"},gap:2,children:[e.jsxs(o,{spacing:1,flex:1,children:[e.jsxs(N,{type:"email",paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:["Correo",e.jsx(b,{component:"span",color:"error.main",ml:.5,children:"*"})]}),e.jsx(C,{name:"adminEmail",size:"small",required:!0,placeholder:"admin.company@domino.com...",InputProps:{startAdornment:e.jsx(I,{position:"start",children:e.jsx(W,{})})},disabled:h})]}),e.jsxs(o,{spacing:1,children:[e.jsx(N,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:"Teléfono"}),e.jsx(C,{name:"adminPhone",type:"tel",size:"small",placeholder:"55 5555 5555",InputProps:{startAdornment:e.jsx(I,{position:"start",children:e.jsx(V,{})})},disabled:h})]})]})]}),e.jsx(o,{sx:{pt:1},children:e.jsx(B,{size:"large",loading:h,variant:"contained",color:"primary",fullWidth:!0,type:"submit",children:s?"Actualizar":"Crear"})})]})})};Z.propTypes={adminUsers:j.array,costCenter:j.shape({adminUsers:j.array,id:j.any,name:j.string}),onSuccess:j.func};export{Z as default};
//# sourceMappingURL=SpeiNewCostCenterForm-B76WBDt4.js.map
