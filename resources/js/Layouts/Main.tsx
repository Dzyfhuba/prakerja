import Footer from "@/Components/Footer"
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

      <main className="min-h-[150vh]">
        {props.children}
      </main>

      <Footer />
    </>
  )
}

export default Main
