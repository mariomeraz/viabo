import{P as d,i as r,aR as m,bn as y,T as h,r as j,B as S,bg as g,y as k,a as f,dV as A,S as x,V as B}from"./vendor-5lkxkETF.js";import{A as C,e as F,u,f as M,c as T,C as D}from"./AdminDashboardViaboSpei-B1bJP65o.js";import"./index-DkbAsBWZ.js";import"./viabo-spei-paths-CvU5WLsk.js";import"./formatNumber-dGNhWwxT.js";import"./formatTime-jCgU2sMR.js";import"./matchTypes-mENztEWg.js";import"./TextMaxLine-B63DtfW-.js";import"./formik.esm-CTTSENmf.js";import"./UploadSingleFile-ByYCreVQ.js";import"./fade-CViozI82.js";import"./transition-anLY3gj9.js";import"./filterSearch-NGUmCbyG.js";import"./usePagination-Xa7qo0UK.js";import"./HeaderPage-Bqn_U64p.js";const b=({movementsGrouped:o,isLoading:i,...s})=>{var p;return r.jsxs(m,{disablePadding:!0,...s,sx:{width:"100%",position:"relative",overflow:"auto",maxHeight:600,"& ul":{padding:0}},subheader:r.jsx("li",{}),children:[!i&&o&&((p=Object.entries(o))==null?void 0:p.map(([a,t])=>r.jsx("li",{children:r.jsxs("ul",{children:[r.jsx(y,{sx:{backgroundColor:e=>e.palette.mode==="dark"?e.palette.background.paper:"#EBF0F0",backdropFilter:"blur(10px)",WebkitBackdropFilter:"blur(10px)",fontWeight:"bold",color:"text.primary",py:1},children:r.jsx(h,{variant:"subtitle1",color:"text.secondary",children:a})}),t==null?void 0:t.map(e=>r.jsx(C,{movement:e},e==null?void 0:e.id))]})},`section-${a}`))),i&&[...Array(20)].map((a,t)=>r.jsx(F,{},t))]})};b.propTypes={isLoading:d.any,movementsGrouped:d.any};const w=({isEmptyAccount:o})=>{var l,c;const i=u(n=>n.selectedAccount),s=u(n=>n.stpAccounts),p=M({limit:10,account:(l=i==null?void 0:i.account)==null?void 0:l.number},{enabled:!!((c=i==null?void 0:i.account)!=null&&c.number)}),{isLoading:a,data:t}=p,e=j.useMemo(()=>T(s==null?void 0:s.type),[s]);return r.jsxs(S,{component:D,variant:"outlined",sx:n=>({backdropFilter:"blur(10px)",WebkitBackdropFilter:"blur(10px)"}),children:[r.jsx(g,{sx:{p:2},title:"Últimas transacciones"}),r.jsx(k,{sx:{borderColor:f("#CFDBD5",.7)}}),r.jsx(A,{sx:{p:0},children:o?r.jsx(x,{pt:3,px:3,children:r.jsxs(B,{severity:"info",children:["No tienes ",e," asignados"]})}):r.jsx(x,{flexDirection:"row",sx:{height:"100%",display:"flex",flexGrow:1},children:r.jsx(b,{movementsGrouped:t==null?void 0:t.groupByDay,isLoading:a})})})]})};w.propTypes={isEmptyAccount:d.any};export{w as default};
//# sourceMappingURL=AdminSpeiMovements-Bu0cO8hK.js.map
