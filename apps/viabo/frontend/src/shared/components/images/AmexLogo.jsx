import { Box, useTheme } from '@mui/material'

export function AmexLogo({ sx, color }) {
  const theme = useTheme()

  return (
    <Box sx={{ width: 50, height: 50, display: 'flex', alignItems: 'center', ...sx }}>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 -9 58 58">
        <rect width={57} height={39} x={0.5} y={0.5} fill="#006FCF" stroke="#F3F3F3" rx={3.5} />
        <path
          fill="#fff"
          fillRule="evenodd"
          d="M11.863 28.894v-8.235h9.324l1 1.22 1.034-1.22h33.842v7.667s-.885.56-1.908.568h-18.74l-1.128-1.298v1.298h-3.695v-2.216s-.505.31-1.597.31h-1.258v1.906h-5.595l-1-1.246-1.014 1.246h-9.265ZM1 14.453l2.098-4.584h3.628l1.19 2.568V9.869h4.51l.709 1.856.687-1.856h20.244v.933s1.064-.933 2.813-.933l6.568.022 1.17 2.534V9.869h3.774l1.039 1.456V9.869h3.809v8.235H49.43l-.995-1.46v1.46H42.89l-.558-1.298h-1.49l-.549 1.298h-3.76c-1.505 0-2.467-.914-2.467-.914v.914h-5.67l-1.125-1.298v1.298H6.188l-.557-1.298H4.145l-.553 1.298H1v-3.651Zm.01 2.597 2.83-6.166h2.145l2.827 6.166H6.929l-.519-1.235H3.375l-.522 1.235H1.01Zm4.802-2.573-.925-2.158-.928 2.158h1.853Zm3.195 2.572v-6.166l2.617.01 1.523 3.975 1.486-3.985h2.597v6.166h-1.645v-4.543l-1.743 4.543H12.4l-1.749-4.543v4.543H9.007Zm9.348 0v-6.166h5.367v1.38h-3.705v1.054h3.618v1.298h-3.618v1.095h3.705v1.339h-5.367Zm6.319.001v-6.166h3.66c1.213 0 2.3.703 2.3 2 0 1.11-.917 1.824-1.805 1.894l2.164 2.272h-2.01l-1.972-2.19h-.692v2.19h-1.645Zm3.525-4.787h-1.88v1.299h1.904c.33 0 .755-.24.755-.65 0-.318-.328-.649-.78-.649Zm4.785 4.786h-1.68v-6.166h1.68v6.166Zm3.981 0h-.362c-1.754 0-2.819-1.295-2.819-3.057 0-1.807 1.053-3.109 3.268-3.109h1.818v1.46h-1.884c-.9 0-1.535.658-1.535 1.664 0 1.194.727 1.695 1.774 1.695h.433l-.693 1.347Zm.75.001 2.83-6.166h2.144l2.827 6.166h-1.883l-.52-1.235H40.08l-.522 1.235h-1.842Zm4.801-2.573-.925-2.158-.928 2.158h1.853Zm3.192 2.572v-6.166h2.09l2.67 3.874v-3.874h1.645v6.166H50.09l-2.737-3.975v3.975h-1.645Zm-32.72 10.79v-6.166h5.367v1.38H14.65v1.054h3.619v1.298H14.65V26.5h3.705v1.34h-5.367Zm26.297 0v-6.166h5.367v1.38h-3.705v1.054h3.601v1.298h-3.6V26.5h3.704v1.34h-5.367Zm-20.721 0 2.613-3.045-2.676-3.12h2.072l1.593 1.929 1.6-1.93h1.99l-2.64 3.083 2.618 3.083h-2.072l-1.547-1.899-1.51 1.9h-2.041Zm7.365.001v-6.166h3.633c1.49 0 2.361.9 2.361 2.074 0 1.417-1.11 2.145-2.575 2.145h-1.731v1.947h-1.688Zm3.511-4.771h-1.823v1.42h1.818c.48 0 .817-.299.817-.71 0-.438-.339-.71-.812-.71Zm3.198 4.77v-6.166h3.66c1.212 0 2.299.703 2.299 2 0 1.11-.916 1.824-1.805 1.895l2.164 2.271h-2.01l-1.971-2.19h-.693v2.19h-1.644Zm3.524-4.787h-1.88v1.299h1.904c.33 0 .755-.24.755-.65 0-.318-.328-.649-.779-.649Zm9.252 4.787v-1.338h3.291c.487 0 .698-.247.698-.518 0-.259-.21-.521-.698-.521h-1.487c-1.293 0-2.013-.738-2.013-1.847 0-.988.66-1.942 2.58-1.942h3.203l-.692 1.388h-2.77c-.53 0-.693.26-.693.509 0 .255.202.537.606.537h1.558c1.441 0 2.067.766 2.067 1.77 0 1.079-.697 1.962-2.145 1.962h-3.505Zm5.795 0v-1.338H54.5c.487 0 .698-.247.698-.518 0-.259-.21-.521-.698-.521h-1.487c-1.293 0-2.013-.738-2.013-1.847 0-.988.66-1.942 2.58-1.942h3.203l-.692 1.388h-2.77c-.53 0-.693.26-.693.509 0 .255.202.537.606.537h1.558c1.442 0 2.067.766 2.067 1.77 0 1.079-.697 1.962-2.145 1.962h-3.505Z"
          clipRule="evenodd"
        />
      </svg>
    </Box>
  )
}
