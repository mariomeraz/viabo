import{r as S,i as r,S as i,T as u,B as L,A as x,bB as $,aT as M,br as W,aR as q,aP as E,d_ as D,aQ as O,J as G,d$ as H,P as o}from"./vendor-5lkxkETF.js";import{S as J,y as h,a5 as Q}from"./index-DkbAsBWZ.js";import{u as U,d as X}from"./formik.esm-CTTSENmf.js";import{c as b,d as Z,a as _}from"./index.esm-gIIytEq8.js";import{d as f,B as F}from"./AdminDashboardViaboSpei-B1bJP65o.js";import{F as K,R as A,M as Y}from"./TextMaxLine-B63DtfW-.js";import{R as v}from"./RFSelect-DSsw7uR8.js";import"./formatNumber-dGNhWwxT.js";import"./formatTime-jCgU2sMR.js";import"./matchTypes-mENztEWg.js";import"./viabo-spei-paths-CvU5WLsk.js";import"./filterSearch-NGUmCbyG.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";import"./usePagination-Xa7qo0UK.js";import"./HeaderPage-Bqn_U64p.js";import"./UploadSingleFile-ByYCreVQ.js";const rr=({selectedAccount:m,accounts:R,setCurrentBalance:I,insufficient:nr,onSuccess:w,initialValues:P})=>{var y;const g=S.useRef(null),C=window.crypto||window.msCrypto,T=new Uint32Array(1),k=C.getRandomValues(T)[0],B=b().shape({transactions:Z().of(b().shape({amount:_().test("maxAmount","Monto máximo de transferencia $50,000",function(t){return parseFloat(t==null?void 0:t.replace(/,/g,""))<=5e4}).required("La cantidad es requerida"),account:b().nullable().required("La cuenta es requerida")}))}),j=U({initialValues:P||{transactions:[],beneficiary:null,amount:"",concept:""},validateOnChange:!1,validationSchema:B,onSubmit:(t,{setFieldValue:n,setSubmitting:a})=>{var s;return a(!1),n("amount",""),n("beneficiary",null),w({...t,origin:(s=m==null?void 0:m.account)==null?void 0:s.number})}}),{isSubmitting:N,setFieldValue:d,values:e}=j,p=N,V=!(e!=null&&e.beneficiary)||(e==null?void 0:e.amount)===""||Number(e==null?void 0:e.amount)<=0;S.useEffect(()=>{var a;const n=((a=e.transactions)==null?void 0:a.reduce((s,c)=>{const l=c.amount.trim()!==""?parseFloat(c.amount.replace(/,/g,"")):0;return isNaN(l)?s:s+l},0)).toFixed(2);I(n)},[e.transactions]);const z=()=>{d("amount",""),d("beneficiary",null)};return r.jsx(J,{containerProps:{sx:{flexGrow:0,height:"auto"}},children:r.jsx(K,{formik:j,children:r.jsxs(i,{sx:{p:3},children:[r.jsxs(i,{gap:2,children:[r.jsxs(i,{spacing:.5,children:[r.jsx(u,{variant:"caption",fontWeight:"bold",children:"Beneficiario:"}),r.jsx(v,{name:"beneficiary",disabled:p,textFieldParams:{placeholder:"Seleccionar ...",size:"large"},options:R||[],onChange:(t,n)=>{d("beneficiary",n)},renderOption:(t,n)=>{const a=h((n==null?void 0:n.label)||"");return r.jsx(L,{component:"li",...t,children:r.jsxs(i,{direction:"row",spacing:1,alignItems:"center",children:[r.jsx(x,{...a,sx:{...a==null?void 0:a.sx,width:25,height:25,fontSize:12}}),r.jsx("span",{children:n.label})]})})},renderInput:t=>{var a;const n=h(((a=t==null?void 0:t.inputProps)==null?void 0:a.value)||"");return r.jsx($,{...t,size:"large",placeholder:"Seleccionar ...",inputProps:{...t.inputProps},InputProps:{...t.InputProps,startAdornment:r.jsx(M,{position:"start",children:r.jsx(x,{...n,sx:{...n==null?void 0:n.sx,width:25,height:25,fontSize:12}})}),sx:{borderRadius:s=>1,borderColor:f}}})}})]}),r.jsxs(i,{spacing:.5,children:[r.jsx(u,{variant:"caption",fontWeight:"bold",children:"Monto:"}),r.jsx(A,{size:"large",name:"amount",placeholder:"0.00",disabled:p,autoComplete:"off",InputProps:{startAdornment:r.jsx("span",{style:{marginRight:"5px"},children:"$"}),endAdornment:r.jsx("span",{style:{marginRight:"5px"},children:"MXN"}),inputComponent:Y,inputProps:{mask:Number,radix:".",thousandsSeparator:",",padFractionalZeros:!0,min:0,scale:2,value:e.amount,onAccept:t=>{d("amount",t)}},sx:{borderRadius:t=>1,borderColor:f}}})]}),r.jsx(i,{direction:"row",spacing:1,children:r.jsx(F,{type:"button",startIcon:r.jsx(W,{}),disabled:p||V,onClick:()=>{g.current.push({id:k,account:e==null?void 0:e.beneficiary,amount:e==null?void 0:e.amount}),z()},sx:{flexShrink:0,color:"text.primary"},children:"Agregar Transacción"})})]}),r.jsx(X,{name:"transactions",render:t=>(g.current=t,r.jsx(q,{sx:{width:"100%",bgcolor:"background.paper"},children:e==null?void 0:e.transactions.map((n,a)=>{var s,c,l;return r.jsx(i,{children:r.jsxs(E,{sx:{px:0},secondaryAction:r.jsx(Q,{color:"error",edge:"end","aria-label":"delete",onClick:()=>t.remove(a),children:r.jsx(D,{})}),children:[r.jsx(O,{children:r.jsx(x,{title:((s=n==null?void 0:n.account)==null?void 0:s.label)||"",...h(((c=n==null?void 0:n.account)==null?void 0:c.label)||"")})}),r.jsx(G,{primary:r.jsx(u,{variant:"subtitle1",children:(l=n==null?void 0:n.account)==null?void 0:l.clabeHidden}),secondary:r.jsx(u,{variant:"subtitle1",fontWeight:"bold",children:n==null?void 0:n.amount})})]})},n.id)})}))}),r.jsx(A,{fullWidth:!0,name:"concept",multiline:!0,disabled:p,rows:2,label:"Concepto",placeholder:"Transferencia ..",InputProps:{sx:{borderRadius:t=>1,borderColor:f}}}),r.jsx(i,{sx:{pt:3},children:r.jsx(F,{variant:"contained",size:"large",color:"primary",disabled:!!((y=e==null?void 0:e.transactions)!=null&&y.length)<=0,fullWidth:!0,type:"submit",startIcon:r.jsx(H,{}),children:"Siguiente"})})]})})})};rr.propTypes={accounts:o.array,initialValues:o.shape({amount:o.string,beneficiary:o.any,concept:o.string,transactions:o.array}),insufficient:o.any,onSuccess:o.func,selectedAccount:o.shape({account:o.shape({number:o.any}),concentrator:o.shape({number:o.any})}),setCurrentBalance:o.func};export{rr as default};
//# sourceMappingURL=SpeiOutForm-C2ddF_HO.js.map
