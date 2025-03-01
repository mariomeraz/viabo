import { createContext } from "preact"
import { useContext, useEffect, useRef, useState } from "preact/hooks"

import Chevron from "./icons/Chevron"
import Plus from "./icons/Plus"

const initialAccordionContext = {
	selected: "viabo-pay",
	setSelected: () => {},
}

export const AccordionContext = createContext(initialAccordionContext)

function Accordion({ children, value, className, onChange }) {
	const [selected, setSelected] = useState(value)

	useEffect(() => {
		setSelected("viabo-pay")
	}, [])

	return (
		<div className={className}>
			<AccordionContext.Provider value={{ selected, setSelected }}>
				{children}
			</AccordionContext.Provider>
		</div>
	)
}

export default Accordion

export function AccordionItem({ children, value, trigger, ...props }) {
	const { selected, setSelected } = useContext(AccordionContext)

	const open = selected === value
	const ref = useRef(null)

	const handleClick = () => {
		setSelected(open ? null : value)
	}

	return (
		<li className={`border-b ${open ? "mt-5 pb-5" : ""} text-white`} {...props}>
			<div
				role="button"
				onClick={handleClick}
				className={`flex items-center justify-between p-4 text-3xl  ${open ? "bg-primary-dark font-medium text-white" : "font-light text-gray-300"} rounded-lg transition `}
			>
				{trigger}
				{open ? <Chevron size={16} /> : <Plus size={16} />}
			</div>
			<div
				className="overflow-y-hidden transition-all"
				style={{ height: open ? ref.current?.offsetHeight ?? 0 : 0 }}
			>
				<div
					className={`${open ? "animate-fade-in-up" : ""} mt-4 rounded-lg bg-[#39316b] px-4 py-8 `}
					ref={ref}
				>
					{children}
				</div>
			</div>
		</li>
	)
}
