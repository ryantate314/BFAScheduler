class CreateWorkerPositions < ActiveRecord::Migration
  def change
    create_table :worker_positions do |t|
      t.string :description
      t.int :estimatedHours
      t.Worker :has_one

      t.timestamps null: false
    end
  end
end
