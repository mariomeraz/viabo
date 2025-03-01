import Accordion, { AccordionItem } from "../Accordion"
import ServicesDetailsDesktop from "./ServicesDetailsDektop"
import AccordionServiceDesktop from "./ServicesDetailsDesktop"
import { ViaboCardService } from "./ViaboCardService"
import { ViaboMoreServices } from "./ViaboMoreServices"
import { ViaboPayService } from "./ViaboPayService"
import { ViaboSpeiService } from "./ViaboSpeiService"

export const services = [
	{
		title: "Viabo Pay",
		value: "viabo-pay",
		component: ViaboPayService,
	},
	{
		title: "Viabo Card",
		value: "viabo-card",
		component: ViaboCardService,
	},
	{
		title: "Viabo SPEI Cloud",
		value: "viabo-spei",
		component: ViaboSpeiService,
	},
	{
		title: "Más Servicios",
		value: "more-services",
		component: ViaboMoreServices,
	},
]

const AccordionServices = () => {
	return (
		<Accordion>
			<div className="flex w-full flex-col gap-5">
				<div className={"md:hidden"}>
					<div className="text-center md:col-span-2">
						<h2 className="text-4xl font-light text-white">Selecciona tu servicio</h2>
					</div>
					<ul>
						<AccordionItem value="viabo-pay" trigger="Viabo Pay">
							<ViaboPayService />
						</AccordionItem>
						<AccordionItem value="viabo-card" trigger="Viabo Card">
							<ViaboCardService />
						</AccordionItem>
						<AccordionItem value="viabo-spei" trigger="Viabo SPEI Cloud">
							<ViaboSpeiService />
						</AccordionItem>
						<AccordionItem value="more-services" trigger="Más Servicios">
							<ViaboMoreServices />
						</AccordionItem>
					</ul>
				</div>
			</div>
			<div className={"hidden md:block"}>
				<div className={"grid grid-cols-2  gap-10 "}>
					<div className={"flex flex-col justify-start"}>
						<div className="mb-20">
							<h2 className="text-4xl font-light text-white">Selecciona tu servicio</h2>
						</div>
						<ul>
							{services.map((service) => (
								<AccordionServiceDesktop service={service} key={service.id} />
							))}
						</ul>
					</div>

					<ServicesDetailsDesktop />
				</div>
			</div>
		</Accordion>
	)
}

export default AccordionServices
