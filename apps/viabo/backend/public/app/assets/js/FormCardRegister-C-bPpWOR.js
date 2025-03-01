import{bx as S,r as D,f as V,bC as I,bD as v,bE as E,i as e,S as i,T as c,B as F,V as k,aT as M,bF as T,bG as w,aH as P,Q as R,bH as q,K as B}from"./vendor-5lkxkETF.js";import{u as z}from"./formik.esm-CTTSENmf.js";import{c as L,a as y}from"./index.esm-gIIytEq8.js";import{K as N,g as _,b as H,a as U}from"./index-DkbAsBWZ.js";import{u as h,C as b}from"./RegisterCards-C5_I1Y1r.js";import{a as $}from"./RegisterCardsRepository-DirGGdP-.js";import{F as G,R as K,M as W}from"./TextMaxLine-B63DtfW-.js";import"./iconBase-jHcAKz16.js";import"./formatNumber-dGNhWwxT.js";import"./formatTime-jCgU2sMR.js";import"./matchTypes-mENztEWg.js";import"./UploadSingleFile-ByYCreVQ.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";const O=t=>{var p,a;const d=(p=t==null?void 0:t.expiration)==null?void 0:p.slice(-2),o={expiration:((a=t==null?void 0:t.expiration)==null?void 0:a.slice(0,3))+d,cvv:t==null?void 0:t.cvv};return N(o)},Q=(t={})=>{const{enqueueSnackbar:d}=S(),[n,o]=D.useState(null);return{...V($,{onSuccess:()=>{o(null)},onError:a=>{const s=_(a,"No se puede asignar la tarjeta. Intente nuevamente o reporte a sistemas");o(s),d(s,{variant:H(a),autoHideDuration:5e3})},...t}),error:n||null}};function me(){const t=h(r=>r.setStepAssignRegister),d=h(r=>r.token),n=h(r=>r.card),{mutate:o,isLoading:p}=Q(),a=L().shape({cvv:y().min(3,"Debe contener 3 digitos").required("El CVV es requerido"),expiration:y().required("La fecha de vencimiento es requerida").test("is-future-date","La fecha  debe ser mayor que la fecha actual",function(r){const l=I(`01/${r}`,"dd/MM/yyyy",new Date),x=new Date;return v(l)&&E(l,x)})}),s=z({initialValues:{expiration:"",cvv:""},validationSchema:a,onSubmit:(r,{setSubmitting:l})=>{const x=O(r);U.defaults.headers.common.Authorization=`Bearer ${d}`,o(x,{onSuccess:()=>{l(!1),t(b.CARD_ASSIGNED)},onError:()=>{l(!1)}})}}),{isSubmitting:j,values:g,setFieldValue:C,errors:m,handleSubmit:A,touched:f,resetForm:Y,setSubmitting:J}=s,u=j||p;return e.jsxs(i,{sx:{mb:3},children:[e.jsxs(i,{direction:"column",width:1,spacing:1,pb:2,children:[e.jsx(c,{variant:"h4",color:"textPrimary",align:"center",children:"Estamos a un paso de completar su registro"}),e.jsx(c,{paragraph:!0,align:"center",variant:"body1",color:"text.primary",whiteSpace:"pre-line",children:"Ingrese la información faltante de la tarjeta para asociarla a su cuenta."})]}),e.jsx(G,{formik:s,children:e.jsxs(i,{px:5,children:[e.jsx(F,{sx:{pb:1,display:"flex",flexDirection:"column",alignItems:"center",justifyContent:"center",gap:2},children:e.jsx(c,{variant:"overline",color:"primary.main",children:n==null?void 0:n.cardNumberHidden})}),e.jsx(k,{sx:{textAlign:"center",width:"100%",justifyContent:"center",display:"flex",mb:2},severity:"warning",children:e.jsx(c,{variant:"caption",fontWeight:"bold",children:"En caso de no capturar los datos correctos de la tarjeta, la información de la misma podrá ser erronea."})}),e.jsxs(i,{direction:{xs:"column",lg:"row"},spacing:3,display:"flex",children:[e.jsxs(i,{sx:{width:{xs:"100%",lg:"40%"}},children:[e.jsx(c,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:"CVV"}),e.jsx(K,{name:"cvv",required:!0,placeholder:"123",size:"small",InputProps:{startAdornment:e.jsx(M,{position:"start",children:e.jsx(T,{})}),inputComponent:W,inputProps:{mask:"000",onAccept:r=>{C("cvv",r)},value:g.cvv}},disabled:u})]}),e.jsxs(i,{children:[e.jsx(c,{paragraph:!0,variant:"overline",sx:{color:"text.disabled"},children:"Vence"}),e.jsx(w,{disabled:u,views:["year","month"],size:"small",name:"expiration",value:new Date(g.expiration)??null,onChange:r=>v(r)?s.setFieldValue("expiration",P(r,"MM/yyyy")):s.setFieldValue("expiration",""),slotProps:{textField:{fullWidth:!0,size:"small",error:!!(f.expiration&&m.expiration),required:!0,helperText:f.expiration&&m.expiration?m.expiration:""}},disablePast:!0,format:"MM/yy"})]})]})]})}),e.jsxs(i,{spacing:3,px:5,py:4,children:[e.jsx(R,{size:"large",loading:u,variant:"contained",color:"primary",fullWidth:!0,type:"submit",onClick:A,disabled:u,startIcon:e.jsx(q,{}),children:"Asociar"}),e.jsx(B,{size:"large",variant:"outlined",color:"inherit",onClick:()=>{t(b.CARD_VALIDATION)},children:"Cancelar"})]})]})}export{me as default};
//# sourceMappingURL=FormCardRegister-C-bPpWOR.js.map
