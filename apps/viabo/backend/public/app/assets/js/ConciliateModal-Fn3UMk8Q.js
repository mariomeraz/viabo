import{c as O,f as B,U as y,r as N,e as R,i as t,B as A,S as c,V as P,T as S,aM as k}from"./vendor-5lkxkETF.js";import{g as M,b as w}from"./index-DkbAsBWZ.js";import{c as v,F as T,g as z,u as h}from"./FundingOrders-B1tpPoY8.js";import{g as I}from"./cardTypes-DiZXL2sx.js";import{S as D,M as L}from"./MaterialDataTable-Dl1JQ_sM.js";import{a as G}from"./ModalAlert-Ju1kumTl.js";import{u as K}from"./useMaterialTable-8QQmzXWd.js";import"./index-C6YA3NyB.js";import"./iconBase-jHcAKz16.js";import"./operationTypes-DSVpUfFk.js";import"./viabo-card-CcTpX9JZ.js";import"./viabo-pay-Tb0TUikx.js";import"./TextMaxLine-B63DtfW-.js";import"./formik.esm-CTTSENmf.js";import"./formatTime-jCgU2sMR.js";import"./matchTypes-mENztEWg.js";import"./UploadSingleFile-ByYCreVQ.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";import"./formatNumber-dGNhWwxT.js";import"./cardMovementsAdapter-DwJrnLuP.js";import"./HeaderPage-Bqn_U64p.js";import"./AmexLogo-BNm7u8Au.js";import"./CarnetLogo-CFGRKXQt.js";import"./MasterCardLogo-C26mw1FM.js";import"./VisaLogo-BXtVVQaT.js";const V=(r,n)=>({fundingOrderId:r==null?void 0:r.id,conciliationNumber:n==null?void 0:n.id}),Q=(r={})=>{const n=O(),o=B(v,r);return{...o,mutate:async(u,s)=>{const{onSuccess:a,onError:l,mutationOptions:m}=s;try{await y.promise(o.mutateAsync(u,m),{pending:"Conciliando orden de fondeo ...",success:{render({data:i}){return n.invalidateQueries([T.LIST]),a(i),"Se creó la conciliación con éxito"}}})}catch(i){const p=M(i,"No se puede realizar esta operación en este momento. Intente nuevamente o reporte a sistemas");l(p),y.error(p,{type:w(i)})}}}},W=(r,n={})=>{const[o,d]=N.useState(null);return{...R([T.MOVEMENTS,r==null?void 0:r.id],()=>z(r),{staleTime:6e4,refetchOnWindowFocus:!1,onError:s=>{const a=M(s,"No se puede obtener los movimientos de la cuenta");d(a),y.error(a,{type:w(s)})},...n}),error:o||null}},he=()=>{var f;const r=h(e=>e.openConciliateModal),n=h(e=>e.setOpenConciliateModal),o=h(e=>e.fundingOrder),d=h(e=>e.setFundingOrder),{mutate:u,isLoading:s}=Q(),a=[{accessorKey:"description",header:"Movimiento",size:100},{accessorKey:"date",header:"Fecha",size:100},{accessorKey:"amountFormat",header:"Monto",size:100}],{data:l,isError:m,error:i,isLoading:p,isFetching:j}=W(o,{enabled:!!o}),g=I(o==null?void 0:o.paymentProcessorName),F=g==null?void 0:g.component,b=K(m,i,{columns:a,data:(l==null?void 0:l.movements)||[],enableColumnPinning:!0,enableStickyHeader:!0,enableRowVirtualization:!0,enableFacetedValues:!0,enableRowSelection:!0,enableMultiRowSelection:!1,positionActionsColumn:"last",enableDensityToggle:!1,enableColumnResizing:!1,initialState:{density:"compact",sorting:[{id:"date",desc:!0}]},state:{isLoading:p,showAlertBanner:m,showProgressBars:j},muiTablePaperProps:{elevation:0,sx:e=>({borderRadius:0,backgroundColor:e.palette.background.neutral})},muiBottomToolbarProps:{sx:e=>({backgroundColor:e.palette.background.neutral})},muiTopToolbarProps:{sx:e=>({backgroundColor:e.palette.background.neutral})},displayColumnDefOptions:{"mrt-row-select":{maxSize:10,header:""}},renderToolbarInternalActions:({table:e})=>t.jsx(A,{children:t.jsx(D,{table:e})}),muiTableContainerProps:{sx:{maxHeight:"md"}}}),x=((f=b==null?void 0:b.getSelectedRowModel().flatRows)==null?void 0:f.map(e=>e.original))??[],E=()=>{if((x==null?void 0:x.length)>0){const e=V(o,x[0]);u(e,{onSuccess:()=>{C()},onError:()=>{}})}else y.warn("Debe seleccionar un movimiento para conciliar la orden de fondeo")},C=()=>{n(!1),d(null)};return t.jsx(G,{onClose:C,onSuccess:E,isSubmitting:s,fullWidth:!0,scrollType:"body",title:"Conciliar",textButtonSuccess:"Conciliar",open:r,children:t.jsxs(c,{spacing:3,sx:{py:3},children:[t.jsx(P,{severity:"info",sx:{display:"flex",flexGrow:1,"& .MuiAlert-message":{display:"flex",flexGrow:1}},children:t.jsxs(c,{flexGrow:1,spacing:2,direction:"row",justifyContent:"space-between",alignItems:"center",children:[t.jsxs(c,{children:[t.jsxs(S,{variant:"subtitle2",children:["Orden #",o==null?void 0:o.referenceNumber]}),t.jsx(S,{variant:"subtitle2",fontWeight:"bold",children:o==null?void 0:o.amount})]}),t.jsx(c,{children:g&&t.jsx(F,{sx:{width:30,height:30}})})]})}),t.jsx(c,{children:t.jsx(k,{children:t.jsx(L,{table:b})})})]})})};export{he as default};
//# sourceMappingURL=ConciliateModal-Fn3UMk8Q.js.map
