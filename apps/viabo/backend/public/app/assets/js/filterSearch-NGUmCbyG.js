const o=(s,n)=>s.filter(c=>{const r=e=>!e||typeof e!="object"?!1:Object.keys(e).some(t=>typeof e[t]=="object"?r(e[t]):e[t]&&e[t].toString().toLowerCase().includes(n.toLowerCase()));return r(c)});export{o as s};
//# sourceMappingURL=filterSearch-NGUmCbyG.js.map
