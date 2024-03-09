import Navbar from "@/Components/Navbar"
import { User } from "@/types"
import { ReactNode } from "react"

type Props = {
  children: ReactNode
  user?: User
}

const Main = (props: Props) => {
  return (
    <>
      <Navbar user={props.user} />

      <main>
        {props.children}
      </main>
    </>
  )
}

export default Main
