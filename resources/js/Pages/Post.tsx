import Image from "@/Components/Image"
import Main from "@/Layouts/Main"
import Post from "@/types/post"
import Product from "@/types/product"
import { Link } from "@inertiajs/react"
import Markdown from "react-markdown"
import 'swiper/css'
import 'swiper/css/pagination'
import { Autoplay, Pagination } from "swiper/modules"
import { Swiper, SwiperSlide } from "swiper/react"
import { useMediaQuery } from "usehooks-ts"

type Props = {
  item: Post
  products: Product[]
  posts: Post[]
}

const PostPage = (props: Props) => {
  const sm = useMediaQuery('(min-width: 640px)')
  const md = useMediaQuery('(min-width: 1080px)')

  return (
    <Main>
      <article className="pt-14 px-3 prose mx-auto">
        <h1>
          {props.item.title}
        </h1>
        <Markdown>
          {props.item.content}
        </Markdown>
      </article>

      {/* posts */}
      <h2 className="p-3 font-bold text-xl">Related Posts</h2>
      <Swiper
        modules={[Pagination, Autoplay]}
        loop={true}
        pagination={{
          clickable: true,
        }}
        autoplay={{
          delay: 2500,
          disableOnInteraction: false,
        }}
        slidesPerView={md ? 3 : (sm ? 2 : 1)}
        style={{
          height: 180
        }}
      >
        {props.posts?.map(p => (
          <SwiperSlide key={p.id} className="bg-base-200">
            <div className="p-3">
              <div className="p-1 w-full h-full">
                <Link href={`/posts/${p.slug}`}>
                  <h1 className="font-bold link-hover text-xl line-clamp-1">{p.title}</h1>
                </Link>
                <div className="line-clamp-3 text-sm">
                  <Markdown>{p.content}</Markdown>
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>

      {/* products */}
      <h2 className="p-3 font-bold text-xl">Related Products</h2>
      <Swiper
        modules={[Pagination, Autoplay]}
        loop={true}
        pagination={{
          clickable: true,
        }}
        autoplay={{
          delay: 2500,
          disableOnInteraction: false,
        }}
        slidesPerView={md ? 3 : (sm ? 2 : 1)}
        style={{
          height: 190
        }}
      >
        {props.products?.map(p => (
          <SwiperSlide key={p.id} className="bg-base-200">
            <div className="p-3 flex">
              <Image
                src={p.images![0]}
                className="w-52 h-32 object-contain object-center"
              />
              <div className="p-1 w-full h-full">
                <Link href={`/products/${p.slug}`}>
                  <h1 className="font-bold link-hover line-clamp-2">{p.name}</h1>
                </Link>
                <div className="line-clamp-4 text-sm">
                  <Markdown>{p.description}</Markdown>
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
    </Main>
  )
}

export default PostPage
