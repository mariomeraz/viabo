import{c as N,f as P,U as E,s as V,dR as b,P as S,r as w,i as e,dO as I,dP as L,dQ as $,dS as p,dT as q,B as Q,T as f,S as x,b4 as _,dN as W,e6 as k,e1 as T,e7 as C,Q as z}from"./vendor-5lkxkETF.js";import{u as H}from"./formik.esm-CTTSENmf.js";import{c as U,a as F,d as M,g as v}from"./index.esm-gIIytEq8.js";import{a as G,g as K,b as X,S as A}from"./index-DkbAsBWZ.js";import{f as R}from"./formatNumber-dGNhWwxT.js";import{D as Y,C as J}from"./useToggleStatusCard-DsdEWGTJ.js";import{i as B}from"./matchTypes-mENztEWg.js";import{F as Z,R as O,d as ee,e as ie}from"./TextMaxLine-B63DtfW-.js";import"./cardsAdapter-CnGv3jFq.js";import"./formatTime-jCgU2sMR.js";import"./cardMovementsAdapter-DwJrnLuP.js";import"./UploadSingleFile-ByYCreVQ.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";const ae=async a=>{const{data:t}=await G.post("/api/card/add/receipt",a);return t},se=(a={})=>{const t=N(),i=P({mutationFn:ae,...a});return{...i,mutate:async(d,h)=>{const{onSuccess:c,onError:n,...g}=h;try{await E.promise(i.mutateAsync(d,g),{pending:"Comprobando movimientos ...",success:{render({data:r}){return t.invalidateQueries([Y.MOVEMENTS]),t.invalidateQueries([J.CARD_MOVEMENTS]),B(c)&&c(r),"Se creó la comprobación con éxito"}}})}catch(r){const m=K(r,"No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas");B(n)&&n(m),E.error(m,{type:X(r)})}}}};V(b)(({theme:a})=>({"& td":{paddingTop:a.spacing(.5),paddingBottom:a.spacing(.5)}}));const D=({movements:a=[]})=>{const t=w.useMemo(()=>a==null?void 0:a.reduce((i,o)=>{const d=o!=null&&o.amount?o==null?void 0:o.amount:0;return isNaN(d)?i:i+d},0),[a]);return e.jsxs(e.Fragment,{children:[e.jsx(A,{sx:{maxHeight:400},children:e.jsx(I,{sx:{minWidth:200},children:e.jsxs(L,{children:[e.jsx($,{sx:{borderBottom:i=>`solid 1px ${i.palette.divider}`},children:e.jsxs(b,{children:[e.jsx(p,{width:40,children:"#"}),e.jsx(p,{sx:{minWidth:150},align:"left",children:"Movimiento"}),e.jsx(p,{align:"left",children:"Fecha"}),e.jsx(p,{align:"right",children:"Monto"})]})}),e.jsx(q,{children:a==null?void 0:a.map((i,o)=>e.jsxs(b,{sx:{borderBottom:d=>`solid 1px ${d.palette.divider}`},children:[e.jsx(p,{children:o+1}),e.jsx(p,{align:"left",children:e.jsx(Q,{sx:{maxWidth:200},children:e.jsx(f,{variant:"subtitle2",children:i==null?void 0:i.description})})}),e.jsx(p,{children:e.jsx(f,{variant:"subtitle2",children:i==null?void 0:i.date})}),e.jsx(p,{align:"right",children:R(i==null?void 0:i.amount)})]},o))})]})})}),e.jsx(x,{justifyContent:"flex-end",direction:"row",children:e.jsxs(x,{direction:"row",spacing:2,px:2,children:[e.jsx(f,{variant:"h6",children:"Total"}),e.jsx(f,{variant:"h6",children:R(t)})]})})]})};D.propTypes={movements:S.array};const oe=(a,t)=>{const{files:i,note:o,method:d,singleFile:h}=a,c=d==="invoice",n=new FormData;c&&(i==null||i.forEach(r=>{n.append("files[]",r)})),!c&&h&&n.append("files[]",h);const g=(t==null?void 0:t.map(r=>({...r==null?void 0:r.original})))||[];return n.append("movements",JSON.stringify(g)),n.append("note",o),n.append("isInvoice",c),n},ne=({movements:a=[],onSuccess:t})=>{const{mutate:i,isLoading:o}=se(),d=U().shape({note:F().when(["method","singleFile"],{is:(s,l)=>s!=="invoice"&&!l,then:s=>s.trim().required("La nota es requerida cuando no existe un archivo."),otherwise:s=>F()}),method:F(),files:M().when("method",{is:"invoice",then:s=>s.max(2,"Cargar máximo 2 archivos por factura.").test("fileFormat","Se requiere el archivo PDF y XML de la factura.",function(l){const u=l.filter(y=>y.type==="application/pdf").length,j=l.filter(y=>["text/xml","application/xml"].includes(y.type)).length;return u===1&&j===1}),otherwise:s=>M()}),singleFile:v().when("method",{is:s=>s!=="invoice",then:s=>s.when(["method","note"],{is:(l,u)=>l!=="invoice"&&!u,then:l=>l.required("El archivo es requerido cuando no hay una nota."),otherwise:l=>v().nullable()}),otherwise:s=>v().nullable()})}),h=H({initialValues:{note:"",method:"invoice",files:[],singleFile:null},validationSchema:d,onSubmit:(s,{setSubmitting:l,setFieldValue:u})=>{const j=oe(s,a);i(j,{onSuccess:()=>{t(),l(!1)},onError:()=>{u("files",[]),u("singleFile",null),l(!1)}})}}),{values:c,setFieldValue:n,setTouched:g,isSubmitting:r}=h,m=c.method==="invoice";return e.jsxs(A,{containerProps:{sx:{flexGrow:0,height:"auto"}},children:[e.jsx(D,{movements:a}),e.jsx(Z,{formik:h,children:e.jsxs(x,{spacing:2,sx:{p:3},children:[e.jsx(x,{children:e.jsxs(_,{disabled:o,children:[e.jsx(W,{id:"demo-row-radio-buttons-group-label",children:" Seleccione el método de comprobación:"}),e.jsxs(k,{value:c.method,onChange:s=>{n("method",s.target.value),n("files",[]),n("singleFile",null),g({},!1)},row:!0,"aria-labelledby":"demo-row-radio-buttons-group-label",name:"row-radio-buttons-group",children:[e.jsx(T,{value:"invoice",control:e.jsx(C,{}),label:"Factura (XML y PDF)"}),e.jsx(T,{value:"image",control:e.jsx(C,{}),label:"Nota o archivo (Imagen o PDF)"})]})]})}),!m&&e.jsxs(x,{spacing:1,children:[e.jsx(f,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:"Nota:"}),e.jsx(O,{name:"note",multiline:!0,rows:1,placeholder:"Motivo de la comprobación..."})]}),e.jsxs(x,{spacing:1,children:[e.jsx(f,{variant:"overline",sx:{color:"text.disabled",width:1},children:"Archivos (Max - 3MB):"}),m?e.jsx(ee,{name:"files",maxSize:3145728,accept:{"application/pdf":[".pdf"],"application/xml":[".xml"],"text/xml":[".xml"]},...m?{maxFiles:2}:{}}):e.jsx(ie,{name:"singleFile",maxSize:3145728,accept:{"image/*":[".jpeg",".jpg",".png"],"application/pdf":[".pdf"]}})]}),e.jsx(x,{sx:{pt:1},children:e.jsx(z,{loading:o||r,variant:"contained",color:"primary",fullWidth:!0,type:"submit",children:"Comprobar"})})]})})]})};ne.propTypes={movements:S.array,onSuccess:S.func};export{ne as default};
//# sourceMappingURL=VerifyExpensesForm-Bini9S-s.js.map
