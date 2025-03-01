import { imagesPath } from "../../constants/constants"

export const ViaboMoreServices = ({ isDesktop = false }) => {
	const content = (
		<div className={"flex flex-col items-center justify-center gap-8 text-gray-200"}>
			<div className={"m-auto grid grid-cols-1 content-center md:grid-cols-2"}>
				<div className={"flex flex-col gap-5"}>
					<div className={"block"}>
						<img
							loading="lazy"
							className={"h-auto w-auto"}
							src={`${imagesPath}/viabo-admin-logo.webp`}
							alt={"tipos de procesadores de pago"}
						/>
					</div>
					<span className={"text-xl text-primary-light"}>Sistema operativo integral.</span>
					<p className={"text-xl"}>
						Controla tus movimientos y transacciones sin banco, multiusuario 24/7.
					</p>
					<a
						href="#servicios"
						class="inline-flex min-w-48 items-center justify-center rounded-full bg-gray-100 p-2 text-xl text-primary transition-all hover:scale-105 hover:bg-white"
					>
						Solicitar Demo
					</a>
				</div>

				<div className={"flex flex-col"}>
					<div className={"flex items-center justify-center"}>
						<img
							loading="lazy"
							className={"h-auto w-auto max-w-52"}
							src={`${imagesPath}/viabo-admin.webp`}
							alt={"tipos de procesadores de pago"}
						/>
					</div>
				</div>
			</div>

			<div className={"grid grid-cols-1 content-center md:grid-cols-2"}>
				<div className={"flex flex-col gap-5"}>
					<div className={"block"}>
						<img
							loading="lazy"
							className={"h-auto w-auto  "}
							src={`${imagesPath}/viabo-admin-logo-2.webp`}
							alt={"tipos de procesadores de pago"}
						/>
					</div>
					<span className={"text-xl text-primary-light"}>Tu propio ecosistema transaccional.</span>
					<p className={"text-xl"}>
						Medios de pago y fondeos las 24 horas, los 365 días del año. Movimientos sin banco y
						multiusuario (B2B).
					</p>
					<a
						href="#servicios"
						class="inline-flex min-w-48 items-center justify-center rounded-full bg-gray-100 p-2 text-xl text-primary transition-all hover:scale-105 hover:bg-white"
					>
						Solicitar Demo
					</a>
				</div>
				<div className={"flex flex-col"}>
					<div className={"flex items-center justify-center"}>
						<img
							loading="lazy"
							className={"h-auto w-auto max-w-52"}
							src={`${imagesPath}/viabo-admin-2.webp`}
							alt={"tipos de procesadores de pago"}
						/>
					</div>
				</div>
			</div>
		</div>
	)

	if (isDesktop) {
		return (
			<div
				className={
					"mt-4 animate-fade-in-right rounded-lg bg-[#39316b] px-4 py-8 animate-delay-200 "
				}
			>
				{content}
			</div>
		)
	}
	return content
}
